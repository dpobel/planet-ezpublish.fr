<?php
//
// Created on: <09-Oct-2006 17:00:00 rl>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.3.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

$http = eZHTTPTool::instance();
$Module = $Params['Module'];

//////////////////////
//$userID = eZUser::currentUserID();
$conds = array();
//$conds['user_id'] =  $userID;
$conds['status'] = array( array( eZWorkflow::STATUS_DEFERRED_TO_CRON,
                                 eZWorkflow::STATUS_FETCH_TEMPLATE,
                                 eZWorkflow::STATUS_REDIRECT,
                                 eZWorkflow::STATUS_WAITING_PARENT ) );
$db = eZDB::instance();
if ( $db->databaseName() == 'oracle' )
    $conds['LENGTH(memento_key)'] = array( '!=', 0 );
else
    $conds['memento_key'] = array( '!=', '' );


$offset = $Params['Offset'];
if ( !is_numeric( $offset ) )
{
    $offset = 0;
}

$limitList = array( 1 => 10,
                    2 => 25,
                    3 => 50,
                    4 => 100 );
$limit = 10;
$limitId = eZPreferences::value( 'admin_workflow_processlist_limit' );

if ( $limitId and isset( $limitList[$limitId] ) )
{
    $limit = $limitList[$limitId];
}

$viewParameters = array( 'offset' => $offset );

$plist = eZWorkflowProcess::fetchList( $conds, true, $offset, $limit );
$plistCount = eZWorkflowProcess::count( eZWorkflowProcess::definition(), $conds );

$totalProcessCount = 0;
$outList2 = array();
foreach ( $plist as $p )
{
    $mementoMain = eZOperationMemento::fetchMain( $p->attribute( 'memento_key' ) );
    $mementoChild = eZOperationMemento::fetchChild( $p->attribute( 'memento_key' ) );

    if ( !$mementoMain or !$mementoChild )
        continue;

    $mementoMainData = $mementoMain->data();
    $mementoChildData = $mementoChild->data();

    $triggers = eZTrigger::fetchList( array( 'module_name' => $mementoChildData['module_name'],
                                             'function_name' => $mementoChildData['operation_name'],
                                             'name' => $mementoChildData['name'] ) );
    if ( count( $triggers ) > 0 )
    {
        $trigger = $triggers[0];
        if ( is_object( $trigger ) )
        {
            $nkey = $trigger->attribute( 'module_name' ) . '/' . $trigger->attribute( 'function_name' ) . '/' . $trigger->attribute( 'name' );

            if ( !isset( $outList2[ $nkey ] ) )
            {
                $outList2[ $nkey ] = array( 'trigger' => $trigger,
                                            'process_list' => array() );
            }
            $outList2[ $nkey ][ 'process_list' ][] = $p;
            $totalProcessCount++;
        }
    }
}

// Template handling

$tpl = eZTemplate::factory();

$tpl->setVariable( "module", $Module );
$tpl->setVariable( "trigger_list", $outList2 );
$tpl->setVariable( "total_process_count", $totalProcessCount );
$tpl->setVariable( 'page_limit', $limit );
$tpl->setVariable( 'list_count', $plistCount );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Module->setTitle( "Workflow processes list" );
$Result = array();
$Result['content'] = $tpl->fetch( "design:workflow/processlist.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/workflow', 'Workflow' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/workflow', 'Process list' ),
                                'url' => false ) );

?>

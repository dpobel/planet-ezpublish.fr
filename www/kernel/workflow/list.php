<?php
//
// Created on: <16-Apr-2002 11:00:12 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
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


//include_once( 'kernel/classes/ezworkflow.php' );
//include_once( 'kernel/classes/ezworkflowgroup.php' );
//include_once( 'lib/ezutils/classes/ezhttppersistence.php' );

$Module = $Params['Module'];

// //include_once( 'lib/ezutils/classes/ezexecutionstack.php' );
// $execStack = eZExecutionStack::instance();
// $execStack->clear();
// $execStack->addEntry( $Module->functionURI( 'list' ),
//                       $Module->attribute( 'name' ), 'list' );

$http = eZHTTPTool::instance();

if ( $http->hasPostVariable( 'NewGroupButton' ) )
    return $Module->run( 'groupedit', array() );
if ( $http->hasPostVariable( 'NewWorkflowButton' ) )
    return $Module->run( 'edit', array() );

if ( $http->hasPostVariable( 'DeleteButton' ) and
     $http->hasPostVariable( 'Workflow_id_checked' ) )
{
    eZWorkflow::setIsEnabled( false, $http->postVariable( 'Workflow_id_checked' ) );
}

$groupList = eZWorkflowGroup::fetchList();
$workflows = eZWorkflow::fetchList();
$workflowList = array();
foreach( $workflows as $workflow )
{
    $workflowList[$workflow->attribute( 'id' )] = $workflow;
}

$Module->setTitle( 'Workflow list' );

require_once( 'kernel/common/template.php' );
$tpl = templateInit();

$tpl->setVariable( 'workflow_list', $workflowList );
$tpl->setVariable( 'group_list', $groupList );
$tpl->setVariable( 'module', $Module );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:workflow/list.tpl' );
$Result['path'] = array( array( 'url' => '/workflow/list/',
                                'text' => ezi18n( 'kernel/workflow', 'Workflow list' ) ) );

?>

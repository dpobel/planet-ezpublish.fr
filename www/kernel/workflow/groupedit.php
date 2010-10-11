<?php
//
// Created on: <16-Apr-2002 11:00:12 amos>
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

$Module = $Params['Module'];
if ( isset( $Params["WorkflowGroupID"] ) )
    $WorkflowGroupID = $Params["WorkflowGroupID"];
else
    $WorkflowGroupID = false;

// //include_once( "lib/ezutils/classes/ezexecutionstack.php" );
// $execStack = eZExecutionStack::instance();
// $execStack->addEntry( $Module->functionURI( "groupedit" ) . "/" . $WorkflowGroupID,
//                       $Module->attribute( "name" ), "groupedit" );

if ( is_numeric( $WorkflowGroupID ) )
{
    $workflowGroup = eZWorkflowGroup::fetch( $WorkflowGroupID, true );
}
else
{
    $user = eZUser::currentUser();
    $user_id = $user->attribute( "contentobject_id" );
    $workflowGroup = eZWorkflowGroup::create( $user_id );
    $workflowGroup->setAttribute( "name", ezpI18n::tr( 'kernel/workflow/groupedit', "New WorkflowGroup" ) );
    $WorkflowGroupID = $workflowGroup->attribute( "id" );
}

//$assignedWorkflows = $workflowGroup->fetchWorkflowList();
//$isRemoveTried = false;

$http = eZHTTPTool::instance();
if ( $http->hasPostVariable( "DiscardButton" ) )
{
    $Module->redirectTo( $Module->functionURI( "grouplist" ) );
    return;
}

// Validate input
$requireFixup = false;
// Apply HTTP POST variables
eZHTTPPersistence::fetch( "WorkflowGroup", eZWorkflowGroup::definition(),
                          $workflowGroup, $http, false );

// Set new modification date
$date_time = time();
$workflowGroup->setAttribute( "modified", $date_time );
$user = eZUser::currentUser();
$user_id = $user->attribute( "contentobject_id" );
$workflowGroup->setAttribute( "modifier_id", $user_id );

// Discard existing events, workflow version 1 and store version 0
if ( $http->hasPostVariable( "StoreButton" ) )
{
    if ( $http->hasPostVariable( "WorkflowGroup_name" ) )
    {
        $name = $http->postVariable( "WorkflowGroup_name" );
    }
    $workflowGroup->setAttribute( "name", $name );
    // Set new modification date
    $date_time = time();
    $workflowGroup->setAttribute( "modified", $date_time );
    $user = eZUser::currentUser();
    $user_id = $user->attribute( "contentobject_id" );
    $workflowGroup->setAttribute( "modifier_id", $user_id );
    $workflowGroup->store();
    $Module->redirectTo( $Module->functionURI( 'grouplist' ) );
    return;
}

$Module->setTitle( ezpI18n::tr( 'kernel/workflow', 'Edit workflow group' ) . ' ' .
                   $workflowGroup->attribute( "name" ) );

// Template handling

$tpl = eZTemplate::factory();

$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( "workflow_group", $workflowGroup->attribute( "id" ) ) ) ); // WorkflowGroup ID

$tpl->setVariable( "http", $http );
$tpl->setVariable( "require_fixup", $requireFixup );
$tpl->setVariable( "module", $Module );
$tpl->setVariable( "workflow_group", $workflowGroup );
//$tpl->setVariable( "assigned_workflow_list", $assignedWorkflows );

$Result = array();
$Result['content'] = $tpl->fetch( "design:workflow/groupedit.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/workflow', 'Workflow' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/workflow', 'Group edit' ),
                                'url' => false ) );


?>

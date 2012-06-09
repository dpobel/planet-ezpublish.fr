<?php
/**
 * SOFTWARE NAME: autostatus
 * SOFTWARE RELEASE: 0.2
 * COPYRIGHT NOTICE: Copyright (C) 2009-2011 Damien POBEL
 * SOFTWARE LICENSE: GNU General Public License v2.0
 * NOTICE: >
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of version 2.0  of the GNU General
 *   Public License as published by the Free Software Foundation.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of version 2.0 of the GNU General
 *   Public License along with this program; if not, write to the Free
 *   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *   MA 02110-1301, USA.
 */

autostatusSocialNetwork::fixIncludePath();

$http = eZHTTPTool::instance();
$Module = $Params['Module'];

if ( !isset( $Params['Network'] ) )
{
    eZDebug::writeError( 'Network identifier is missing', 'autostatus/oauth' );
    eZExecution::cleanExit();
}

$network = autostatusSocialNetwork::fetchByIdentifier( $Params['Network'] );

if ( !$network instanceof autostatusSocialNetwork )
{
    eZDebug::writeError( "Invalid network {$Params['Network']}", 'autostatus/oauth' );
    eZExecution::cleanExit();
}

if ( !isset( $Params['WorkflowEventID'] ) )
{
    eZDebug::writeError( 'WorkflowEventID is missing', 'autostatus/oauth' );
    eZExecution::cleanExit();
}

$WorkflowEventID = intval( $Params['WorkflowEventID'] );
$workflowEvent = eZWorkflowEvent::fetch( $WorkflowEventID, true, 1 );
if ( !$workflowEvent instanceof eZWorkflowEvent )
{
    eZDebug::writeError( "WorkflowEventID {$WorkflowEventID} is invalid", 'autostatus/oauth' );
    eZExecution::cleanExit();
}

$config = $network->oauthConfig();

try
{
    $consumer = new Zend_Oauth_Consumer( $config );

    $token = $consumer->getAccessToken( $_GET, unserialize( $http->sessionVariable(autostatusSocialNetwork::TOKEN_SESSION_VAR ) ) );
    $token->social_network = $network->attribute( 'identifier' );
    eZDebug::writeDebug( $token );
    $http->setSessionVariable( autostatusSocialNetwork::TOKEN_SESSION_VAR, null );

    $workflowEvent->setAttribute( 'data_text2', $token->screen_name );
    $workflowEvent->setAttribute( 'data_text5', serialize( $token ) );
    $workflowEvent->store();
}
catch( Exception $e )
{
    eZDebug::writeWarning( 'Not authorized', __METHOD__ );
    $workflowEvent->setAttribute( 'data_text2', '' );
    $workflowEvent->setAttribute( 'data_text5', '' );
    $workflowEvent->store();
}

$editWorkflowURI = 'workflow/edit/' . $workflowEvent->attribute( 'workflow_id' );
eZURI::transformURI( $editWorkflowURI, false, 'full' );
$Module->setExitStatus( eZModule::STATUS_REDIRECT );
$Module->setRedirectURI( $editWorkflowURI );
?>

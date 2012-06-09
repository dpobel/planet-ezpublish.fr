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

class autostatusAjaxFunctions extends ezjscServerFunctions
{

    /**
     * Loads the template to display the auth status in the social network 
     * 
     * @param array $args array( 0 => socialNetworkIdentifier, 1 => eventID )
     * @return string
     */
    public static function auth( $args )
    {
        if ( !isset( $args[0] ) || !isset( $args[1] ) )
        {
            eZDebug::writeError( 'Invalid parameters', __METHOD__ );
            return '';
        }
        $socialNetworkIdentifier = $args[0];
        $eventID = $args[1];
        $network = autostatusSocialNetwork::fetchByIdentifier( $socialNetworkIdentifier );
        if ( !$network instanceof autostatusSocialNetwork )
        {
            eZDebug::writeError( 'Unable to load the social network', __METHOD__ );
            return '';
        }
        $event = eZWorkflowEvent::fetch( $eventID, true, 1 );
        if ( !$event instanceof eZWorkflowEvent )
        {
            eZDebug::writeError( 'Unable to load the workflow event', __METHOD__ );
            return '';
        }
        $tpl = eZTemplate::factory();
        $tpl->setVariable( 'event', $event );
        $tpl->setVariable( 'network', $network );
        return $tpl->fetch( 'design:autostatus/ajax/auth.tpl' );
    }


    /**
     * Tries to update again the status and returns the line to be displayed in 
     * the log view 
     * 
     * @param array $args array( 0 => statusEventID )
     * @access public
     * @return array( 'html' => string, 'class' => string );
     */
    static function retry( $args )
    {
        if ( !isset( $args[0] ) )
        {
            eZDebug::writeError( 'Invalid parameters', __METHOD__ );
            return '';
        }
        $statusEventID = (int) $args[0];
        $status = statusUpdateEvent::fetch( $statusEventID );
        $event = $status->attribute( 'event' );
        if ( !$event instanceof eZWorkflowEvent )
        {
            eZDebug::writeError( 'The workflow event does not exist anymore', __METHOD__ );
            return '';
        }
        $network = $event->attribute( 'social_network' );
        if ( !$network instanceof autostatusSocialNetwork )
        {
            eZDebug::writeError( 'The social network does not exist anymore', __METHOD__ );
            return '';
        }
        $status = self::retryAndUpdateStatus( $event, $network, $status );
        $tpl = eZTemplate::factory();
        $tpl->setVariable( 'event', $status );
        $result = array();
        $result['html'] = $tpl->fetch( 'design:autostatus/event.tpl' );
        $result['class'] = $status->attribute( 'status_text' );
        return $result;
    }


    /**
     * Update the status in $socialNetwork like previously logged in $status 
     * 
     * @param eZWorkflowEvent $event 
     * @param autostatusSocialNetwork $socialNetwork 
     * @param statusUpdateEvent $status 
     * @return statusUpdateEvent
     */
    private static function retryAndUpdateStatus( eZWorkflowEvent $event, autostatusSocialNetwork $socialNetwork, statusUpdateEvent $status )
    {
        autostatusSocialNetwork::fixIncludePath();
        $options = $event->attribute( 'workflow_type' )->getUpdateOptions( $event, $socialNetwork );
        $errorMsg = false;
        $r = statusUpdateEvent::NORMAL;
        $message = $status->attribute( 'message' );
        try
        {
            $ini = eZINI::instance( 'autostatus.ini' );
            if ( $ini->variable( 'AutoStatusSettings', 'Debug' ) === 'disabled' )
            {
                $result = $socialNetwork->update( $message, $options );
                if ( $result->isError() )
                {
                    $errorMsg = $result->error;
                    $r = statusUpdateEvent::ERROR;
                }
            }
            else
            {
                $logFile = $ini->variable( 'AutoStatusSettings', 'LogFile' );
                $logMsg = '[DEBUG] status=' . $message . ' with ' . $login
                    . '@' . $event->attribute( 'social_network_identifier' );
                eZLog::write( $logMsg, $logFile );
            }
        }
        catch( Exception $e )
        {
            $errorMsg = $e->getMessage();
            $r = statusUpdateEvent::EXCEPTION;
            eZDebug::writeError( 'An error occured when updating status in '
                    . $socialNetwork->attribute( 'name' ) . ' : '
                    . $e->getMessage(), 'Auto status workflow' );
        }
        $status->setAttribute( 'status', $r );
        $status->setAttribute( 'error_msg', $errorMsg );
        $status->setAttribute( 'user_id', eZUser::currentUserID() );
        $status->store();
        return $status;
    }


}


?>

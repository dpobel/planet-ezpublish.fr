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

/**
 * Workflow event type to automatically update status
 * in social networks.
 *
 * Informations are stored as followed :
 *  - data_int1 : content class id
 *  - data_int2 : attribute id
 *  - date_int3 : use cronjob
 *  - date_int4 : content attribute, if any, to condition the update
 *  - data_text1 : identifier of the social network
 *  - data_text2 : login on the social network
 *  - data_text3 : password on the social network
 *  - data_text4 : siteaccess to generate URLs for
 *  - data_text5 : oauth access token
 *
 * @uses eZWorkflowEventType
 */
class autostatusType extends eZWorkflowEventType
{
    const WORKFLOW_TYPE_STRING = 'autostatus';


    function __construct()
    {
        parent::__construct( autostatusType::WORKFLOW_TYPE_STRING,
                             ezpI18n::tr( 'kernel/workflow/event', 'Auto status' ) );
        $this->setTriggerTypes( array( 'content' => array( 'publish' => array( 'after' ) ) ) );
    }


    function attributeDecoder( $event, $attr )
    {
        switch( $attr )
        {
            case 'use_cronjob':
            {
                return $event->attribute( 'data_int3' ) != 0;
            }
            case 'class_id':
            {
                return $event->attribute( 'data_int1' );
            }
            case 'class_identifier':
            {
                $classID = $event->attribute( 'data_int1' );
                return eZContentClass::classIdentifierByID( $classID );
            }
            case 'class':
            {
                return eZContentClass::fetch( $event->attribute( 'data_int1' ) );
            }
            case 'attribute_id':
            {
                return $event->attribute( 'data_int2' );
            }
            case 'attribute_identifier':
            {
                $attributeID = $event->attribute( 'data_int2' );
                return eZContentClassAttribute::classAttributeIdentifierByID( $attributeID );
            }
            case 'attribute':
            {
                return eZContentClassAttribute::fetch( $event->attribute( 'data_int2' ) );
            }
            case 'trigger_attribute_id':
            {
                return $event->attribute( 'data_int4' );
            }
            case 'trigger_attribute_identifier':
            {
                $attributeID = $event->attribute( 'data_int4' );
                return eZContentClassAttribute::classAttributeIdentifierByID( $attributeID );
            }
            case 'trigger_attribute':
            {
                return eZContentClassAttribute::fetch( $event->attribute( 'data_int4' ) );
            }
            case 'social_network_identifier':
            {
                return $event->attribute( 'data_text1' );
            }
            case 'social_network':
            {
                return autostatusSocialNetwork::fetchByIdentifier( $event->attribute( 'data_text1' ) );
            }
            case 'login':
            {
                return $event->attribute( 'data_text2' );
            }
            case 'password':
            {
                return $event->attribute( 'data_text3' );
            }
            case 'siteaccess':
            {
                return $event->attribute( 'data_text4' );
            }
            case 'access_token':
            {
                autostatusSocialNetwork::fixIncludePath();
                return unserialize( $event->attribute( 'data_text5' ) );
            }
            case 'access_token_network_identifier':
            {
                $token = $event->attribute( 'access_token' );
                if ( $token instanceof Zend_Oauth_Token_Access )
                {
                    return $token->social_network;
                }
                return '';
            }
        }
        return null;
    }

    function typeFunctionalAttributes()
    {
        return array( 'class_identifier', 'class_id', 'attribute_identifier', 'attribute_id',
                      'class', 'attribute', 'use_cronjob',
                      'trigger_attribute_id', 'trigger_attribute_identifier', 'trigger_attribute',
                      'social_network_identifier', 'social_network', 'login', 'password',
                      'siteaccess', 'access_token', 'access_token_network_identifier' );
    }


    function validateHTTPInput( $http, $base, $event, &$validation )
    {
        $finalState = eZInputValidator::STATE_ACCEPTED;
        if ( !$http->hasPostVariable( 'StoreButton' ) )
        {
            return $finalState;
        }
        $eventID = $event->attribute( 'id' );
        $classIdentifierPostName = 'ClassIdentifier_' . $eventID;
        $attributeIdentifierPostName = 'AttributeIdentifier_' . $eventID;
        $attributeIdentifierForTriggeringPostName = 'AttributeIdentifierTrigger_' . $eventID;
        $socialNetworkPostName = 'SocialNetwork_' . $eventID;
        $loginPostName = 'Login_' . $eventID;
        $passwordPostName = 'Password_' . $eventID;
        $siteaccessPostName = 'Siteaccess_' . $eventID;

        $prefix = $event->attribute( 'workflow_type' )->attribute( 'group_name' ) . ' / '
                  . $event->attribute( 'workflow_type' )->attribute( 'name' ) . ' : ';
        $validation['processed'] = true;
        if ( !$http->hasPostVariable( $classIdentifierPostName )
                || !is_numeric( eZContentClass::classIDByIdentifier( $http->postVariable( $classIdentifierPostName ) ) ) )
        {
            $finalState = eZInputValidator::STATE_INVALID;
            $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Invalid content class' ) );
        }
        else
        {
            $event->setAttribute( 'data_int1', eZContentClass::classIDByIdentifier( $http->postVariable( $classIdentifierPostName ) ) );
        }
        if ( !$http->hasPostVariable( $attributeIdentifierPostName )
                || !is_numeric( eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                                       . '/' . $http->postVariable( $attributeIdentifierPostName ) ) ) )
        {
            $finalState = eZInputValidator::STATE_INVALID;
            $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Invalid attribute' ) );
        }
        else
        {
            $event->setAttribute( 'data_int2', eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                                                      . '/' . $http->postVariable( $attributeIdentifierPostName ) ) );
        }
        if ( !$http->hasPostVariable( $attributeIdentifierForTriggeringPostName ) )
        {
            $finalState = eZInputValidator::STATE_INVALID;
            $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Invalid way of triggering the udpate (none actually)' ) );
        }
        else
        {
            $value = $http->postVariable( $attributeIdentifierForTriggeringPostName );
            if ( eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                        . '/' . $http->postVariable( $attributeIdentifierForTriggeringPostName ) ) )
            {
                $value = eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                        . '/' . $http->postVariable( $attributeIdentifierForTriggeringPostName ) );
            }
            $event->setAttribute( 'data_int4', $value );
        }
        $socialNetwork = null;
        if ( !$http->hasPostVariable( $socialNetworkPostName ) )
        {
            $finalState = eZInputValidator::STATE_INVALID;
            $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'You need to choose a social network' ) );
        }
        else
        {
            $socialNetwork = autostatusSocialNetwork::fetchByIdentifier( $http->postVariable( $socialNetworkPostName ) );
            if ( $socialNetwork instanceof autostatusSocialNetwork )
            {
                $event->setAttribute( 'data_text1', $http->postVariable( $socialNetworkPostName ) );
            }
            else
            {
                $finalState = eZInputValidator::STATE_INVALID;
                $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Invalid social network' ) );
            }
        }

        if ( $socialNetwork !== null && !$socialNetwork->requireOauth() )
        {
            if ( !$http->hasPostVariable( $loginPostName )
                    || $http->postVariable( $loginPostName ) == '' )
            {
                $finalState = eZInputValidator::STATE_INVALID;
                $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Login cannot be empty' ) );
            }
            else
            {
                $event->setAttribute( 'data_text2', $http->postVariable( $loginPostName ) );
            }
            if ( !$http->hasPostVariable( $passwordPostName )
                    || $http->postVariable( $passwordPostName ) == '' )
            {
                $finalState = eZInputValidator::STATE_INVALID;
                $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'Password cannot be empty' ) );
            }
            else
            {
                $event->setAttribute( 'data_text3', $http->postVariable( $passwordPostName ) );
            }
        }
        else if ( $socialNetwork !== null )
        {
            $event->setAttribute( 'data_text3', '' );
            $token = $event->attribute( 'access_token' );
            if ( $token instanceof Zend_Oauth_Token_Access && $token->social_network === $socialNetwork->attribute( 'identifier' ) )
            {
                $event->setAttribute( 'data_text2', $token->screen_name );
            }
            else if ( $token instanceof Zend_Oauth_Token_Access && $token->social_network !== $socialNetwork->attribute( 'identifier' ) )
            {
                $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'The OAuth access token does not correspond to the selected social network' ) );
                $finalState = eZInputValidator::STATE_INVALID;
            }
            else
            {
                $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'You have to check your OAuth access' ) );
                $finalState = eZInputValidator::STATE_INVALID;
            }
        }

        if ( !$http->hasPostVariable( $siteaccessPostName )
                || $http->postVariable( $siteaccessPostName ) == '' )
        {
            $finalState = eZInputValidator::STATE_INVALID;
            $validation['groups'][] = array( 'text' => $prefix . ezpI18n::tr( 'kernel/workflow/event', 'No values given for siteaccess' ) );
        }
        else
        {
            $event->setAttribute( 'data_text4', $http->postVariable( $siteaccessPostName ) );
        }

        return $finalState;
    }


    function fetchHTTPInput( $http, $base, $event )
    {
        if ( !$http->hasPostVariable( 'StoreButton' ) )
        {
            return;
        }
        $eventID = $event->attribute( 'id' );
        $classIdentifierPostName = 'ClassIdentifier_' . $eventID;
        $attributeIdentifierPostName = 'AttributeIdentifier_' . $eventID;
        $triggerAttributeIdentifierPostName = 'AttributeIdentifierTrigger_' . $eventID;
        $socialNetworkPostName = 'SocialNetwork_' . $eventID;
        $loginPostName = 'Login_' . $eventID;
        $passwordPostName = 'Password_' . $eventID;
        $useCronjobPostName = 'UseCronjob_' . $eventID;
        $siteaccessPostName = 'Siteaccess_' . $eventID;

        $event->setAttribute( 'data_int1', eZContentClass::classIDByIdentifier( $http->postVariable( $classIdentifierPostName ) ) );
        $event->setAttribute( 'data_int2', eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                                                  . '/' . $http->postVariable( $attributeIdentifierPostName ) ) );
        $value = $http->postVariable( $triggerAttributeIdentifierPostName );
        if ( eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                    . '/' . $http->postVariable( $triggerAttributeIdentifierPostName ) ) )
        {
            $value = eZContentClassAttribute::classAttributeIDByIdentifier( $http->postVariable( $classIdentifierPostName )
                                                                    . '/' . $http->postVariable( $triggerAttributeIdentifierPostName ) );
        }
        $event->setAttribute( 'data_int4', $value );

        $event->setAttribute( 'data_int3', intval( $http->hasPostVariable( $useCronjobPostName ) ) );
        $event->setAttribute( 'data_text1', $http->postVariable( $socialNetworkPostName ) );
        $network = autostatusSocialNetwork::fetchByIdentifier( $http->postVariable( $socialNetworkPostName ) );
        if ( !$network->requireOauth() )
        {
            $event->setAttribute( 'data_text2', $http->postVariable( $loginPostName ) );
            $event->setAttribute( 'data_text3', $http->postVariable( $passwordPostName ) );
        }
        $event->setAttribute( 'data_text4', $http->postVariable( $siteaccessPostName ) );
    }

    function customWorkflowEventHTTPAction( $http, $action, $workflowEvent )
    {
        autostatusSocialNetwork::fixIncludePath();
        if ( $action === 'OAuthCheck' )
        {
            $networkIdentifier = $http->postVariable( 'SocialNetwork_' . $workflowEvent->attribute( 'id' ) );
            $network = autostatusSocialNetwork::fetchByIdentifier( $networkIdentifier );
            if ( !$network instanceof autostatusSocialNetwork )
            {
                // TODO handle error ?
                return ;
            }
            $workflowEvent->setAttribute( 'data_text1', $networkIdentifier );
            $workflowEvent->store();
            $uri = 'autostatus/oauth/' . $networkIdentifier . '/' . $workflowEvent->attribute( 'id' );
            eZURI::transformURI( $uri, false, 'full' );
            $config = $network->oauthConfig( $uri );
            $consumer = new Zend_Oauth_Consumer( $config );
            $token = $consumer->getRequestToken();
            $http->setSessionVariable( autostatusSocialNetwork::TOKEN_SESSION_VAR, serialize( $token ) );
            $redirectURL = $consumer->getRedirectUrl();
            eZHTTPTool::redirect( $redirectURL );
            eZExecution::cleanExit();
        }
    }

    /**
     * Return the array needed by autostatusSocialNetwork::update() to 
     * identify the user in $socialNetwork
     *
     * @param eZWorkflowEvent $event 
     * @param autostatusSocialNetwork $socialNetwork 
     * @access public
     * @return array
     */
    function getUpdateOptions( eZWorkflowEvent $event, autostatusSocialNetwork $socialNetwork )
    {
        $options = array();
        if ( $socialNetwork->attribute( 'require_oauth' ) )
        {
            $options['token'] = $event->attribute( 'access_token' );
        }
        else
        {
            $options['login'] = $event->attribute( 'login' );
            $options['password'] = $event->attribute( 'password' );
        }
        return $options;
    }

    function execute( $process, $event )
    {
        $parameters = $process->attribute( 'parameter_list' );
        eZDebug::writeDebug( $parameters, __METHOD__ );

        autostatusSocialNetwork::fixIncludePath();

        $classIdentifier = $event->attribute( 'class_identifier' );
        $object = eZContentObject::fetch( $parameters['object_id'] );
        if ( !is_object( $object ) )
        {
            eZDebug::writeError( 'Object id ' . $parameters['object_id']
                                              . ' does not exist...', __METHOD__ );
            return eZWorkflowEventType::STATUS_WORKFLOW_CANCELLED;
        }
        if ( $object->attribute( 'class_identifier' ) != $classIdentifier )
        {
            eZDebug::writeDebug( $classIdentifier . ' != '
                                 . $object->attribute( 'class_identifier' ), __METHOD__ );
            return eZWorkflowEventType::STATUS_ACCEPTED;
        }

        $socialNetwork = $event->attribute( 'social_network' );
        if ( !is_object( $socialNetwork ) )
        {
            eZDebug::writeError( 'Cannot load autostatus object', __METHOD__ );
            return eZWorkflowEventType::STATUS_ACCEPTED;
        }
        $dataMap = $object->attribute( 'data_map' );
        $attributeIdentifier = $event->attribute( 'attribute_identifier' );
        if ( !isset( $dataMap[$attributeIdentifier] ) )
        {
            eZDebug::writeError( 'Cannot find ' . $attributeIdentifier . ' attribute', __METHOD__ );
            return eZWorkflowEventType::STATUS_ACCEPTED;
        }
        if ( !$dataMap[$attributeIdentifier]->hasContent() )
        {
            eZDebug::writeDebug( 'Attribute "' . $attributeIdentifier . '" is empty', __METHOD__ );
            return eZWorkflowEventType::STATUS_ACCEPTED;
        }

        if ( $event->attribute( 'trigger_attribute_id' ) == -1 or
             ( $event->attribute( 'trigger_attribute' ) and
               $dataMap[$event->attribute( 'trigger_attribute_identifier' )]->attribute( 'content' )
             )
           )
        {
            $ini = eZINI::instance( 'autostatus.ini' );
            $shortener = new autostatusShortener( $ini->variable( 'URLShorteningSettings', 'Shortener' ) );
            if ( isset( $parameters['message'] ) )
            {
                $message = $parameters['message'];
            }
            else
            {
                $message = $socialNetwork->substituteFormats( $dataMap[$attributeIdentifier]->attribute( 'content' ), $object, $event, $shortener );
            }
            if ( $event->attribute( 'use_cronjob' ) && !isset( $parameters['in_cronjob'] ) )
            {
                $parameters['in_cronjob'] = true;
                $parameters['message'] = $message;
                $process->setParameters( $parameters );
                $process->store();
                return eZWorkflowEventType::STATUS_DEFERRED_TO_CRON_REPEAT;
            }
            eZDebug::writeDebug( $message, __METHOD__ );

            $options = $this->getUpdateOptions( $event, $socialNetwork );
            $errorMsg = false;
            $status = statusUpdateEvent::NORMAL;
            try
            {
                if ( $ini->variable( 'AutoStatusSettings', 'Debug' ) === 'disabled' )
                {
                    $result = $socialNetwork->update( $message, $options );
                    if ( $result->isError() )
                    {
                        $errorMsg = $result->error;
                        $status = statusUpdateEvent::ERROR;
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
                $status = statusUpdateEvent::EXCEPTION;
                eZDebug::writeError( 'An error occured when updating status in '
                                     . $socialNetwork->attribute( 'name' ) . ' : '
                                     . $e->getMessage(), 'Auto status workflow' );
            }
            $statusEvent = statusUpdateEvent::create(
                $event->attribute( 'id' ), $message, $errorMsg, $status,
                $parameters['user_id'], $parameters['object_id']
            );
            $statusEvent->store();
        }
        return eZWorkflowEventType::STATUS_ACCEPTED;
    }
}

eZWorkflowEventType::registerEventType( autostatusType::WORKFLOW_TYPE_STRING, 'autostatusType' );

?>

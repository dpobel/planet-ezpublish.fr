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

class autostatusTwitter extends autostatusSocialNetwork
{

    public function __construct()
    {
        $this->identifier = 'twitter';
        $this->name = 'Twitter';
    }


    public function update( $message, $options )
    {
        $token = $options['token'];
        $client = new autostatusTwitterClient(
            array(
                'username' => $token->screen_name,
                'accessToken' => $token
            )
        );
        $response = $client->statusUpdate( $message );
        eZDebug::writeDebug( $response );
        return $response;
    }

    /**
     * @link parent::getMaxMessageLength()
     * @see parent::getMaxMessageLength()
     * @see autostatusTwitterClient::STATUS_MAX_CHARACTERS
     */
    public function getMaxMessageLength()
    {
        /*
         * While a longer message will be shortened automatically, and the reminder linked to,
         * ensuring the sent message does not exceed 140 characters makes
         * it readable by all clients, even those not supporting the linked-remainder feature.
         */
        // return autostatusTwitterClient::STATUS_MAX_CHARACTERS;
        return 140;
    }


    /**
     * @link parent::oauthConfig()
     */
    public function oauthConfig( $callbackUrl = '' )
    {
        $ini = eZINI::instance( 'autostatus.ini' );
        $config = array(
            'siteUrl' => $ini->variable( 'TwitterSettings', 'SiteURL' ),
            'consumerKey' => $ini->variable( 'TwitterSettings', 'ConsumerKey' ),
            'consumerSecret' => $ini->variable( 'TwitterSettings', 'ConsumerSecret' )
        );
        if ( $callbackUrl != '' )
        {
            $config['callbackUrl'] = $callbackUrl;
        }
        return $config;
    }

    /**
     * @link parent::requireOauth()
     */
    public function requireOauth()
    {
        return true;
    }
}


?>

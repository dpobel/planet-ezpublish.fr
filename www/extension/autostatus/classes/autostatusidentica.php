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

class autostatusIdentica extends autostatusSocialNetwork
{

    public function __construct()
    {
        $this->identifier = 'identica';
        $this->name = 'Identi.ca';
    }


    public function update( $message, $options )
    {
        $token = $options['token'];
        $opt = $this->oauthConfig();
        $opt['username'] = '';
        $opt['accessToken'] = $token;
        $client = new autostatusIdenticaClient( $opt );
        $response = $client->statusUpdate( $message );
        return $response;
    }

    /**
     * @link parent::getMaxMessageLength()
     * @see parent::getMaxMessageLength()
     */
    public function getMaxMessageLength()
    {
        return null;
    }

    /**
     * @link parent::oauthConfig()
     */
    public function oauthConfig( $callbackUrl = '' )
    {
        $ini = eZINI::instance( 'autostatus.ini' );
        $config = array(
            'siteUrl' => $ini->variable( 'IdenticaSettings', 'SiteURL' ),
            'consumerKey' => $ini->variable( 'IdenticaSettings', 'ConsumerKey' ),
            'consumerSecret' => $ini->variable( 'IdenticaSettings', 'ConsumerSecret' )
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

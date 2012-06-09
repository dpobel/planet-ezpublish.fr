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

class autostatusShortener
{

    /**
     * The service object specific to the choosen shortener
     *
     * @var autostatusShortenerService
     */
    protected $service;


    /**
     * __construct 
     * 
     * @param string $shortenerCode 
     */
    public function __construct( $shortenerCode )
    {
        $className = 'autostatusShortenerService' . ucfirst( $shortenerCode );
        $ini = eZINI::instance( 'autostatus.ini' );
        if ( class_exists( $className ) && $ini->hasGroup( 'URLShortener_' . $shortenerCode ) )
        {
            $this->service = new $className( $ini->group( 'URLShortener_' . $shortenerCode ) );
        }
        else
        {
            eZDebug::writeError( "Cannot find URL shortener '{$shortenerCode}'", __METHOD__ );
        }
    }

    /**
     * Shorten the $url by calling the service
     *
     * @param string $url 
     * @return string
     */
    public function shorten( $url )
    {
        if ( $this->service instanceof autostatusShortenerService )
        {
            $short = $this->service->shorten( $url );
            eZDebug::writeDebug( "Shortened {$url} to {$short}", __METHOD__ );
            return $short;
        }
        return $url;
    }

    /**
     * Returns the maximum length of a shortened URL or 0 if there's no limit 
     * or if no shorten service is defined.
     * 
     * @return int
     */
    public function length()
    {
        if ( $this->service instanceof autostatusShortenerService )
        {
            return $this->service->length();
        }
        return 0;
    }

}


?>

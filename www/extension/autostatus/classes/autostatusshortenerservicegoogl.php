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

class autostatusShortenerServiceGoogl extends autostatusShortenerService
{
    const SERVICE_URL = 'https://www.googleapis.com/urlshortener/v1/url';

    private function getServiceUrl()
    {
        $url = self::SERVICE_URL;
        if ( isset( $this->params['ApiKey'] ) && $this->params['ApiKey'] !== '' )
        {
            $url .= '?key=' . $this->params['ApiKey'];
        }
        return $url;
    }

    public function shorten( $url )
    {
        $options = array( "http" =>
            array(
                "ignore_errors" => true,
                "method" => "POST",
                "header" => "Content-Type: application/json\r\n",
                "content" => json_encode( array( 'longUrl' => $url ) ),
            )
        );
        $context = stream_context_create( $options );
        $result = @file_get_contents( $this->getServiceUrl(), false, $context );
        if ( !isset( $http_response_header ) || !isset( $http_response_header[0] ) )
        {
            eZDebug::writeError( "Failed to get '{$apiURL}'", __METHOD__ );
            return $url;
        }
        else if ( $http_response_header[0] != 'HTTP/1.1 200 OK' &&
                    $http_response_header[0] != 'HTTP/1.0 200 OK' )
        {
            eZDebug::writeError( "An error occured while shortening: '{$result}'", __METHOD__ );
            return $url;
        }
        $resultStruct = json_decode( $result, true );
        if ( $resultStruct === null || !isset( $resultStruct['id'] ) )
        {
            eZDebug::writeError( "Failed to decode json '{$result}'", __METHOD__ );
            return $url;
        }
        return $resultStruct['id'];
    }


}

?>

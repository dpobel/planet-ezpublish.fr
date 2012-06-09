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
 * Clients class for Identi.ca social network.
 * 
 * @uses autostatusTwitterClient
 * @author Damien Pobel
 */
class autostatusIdenticaClient extends autostatusTwitterClient
{
    const OAUTH_BASE_URI = 'https://identi.ca/api/oauth';

    /**
     * Copy paste from Zend_Service_Twitter::__construct() to customize some 
     * hardcoded parameters
     */
    public function __construct( $options = null, Zend_Oauth_Consumer $consumer = null )
    {
        $this->setUri('https://identi.ca/api');
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (!is_array($options)) {
            $options = array();
        }
        $options['siteUrl'] = self::OAUTH_BASE_URI;

        $this->_options = $options;
        if (isset($options['username'])) {
            $this->setUsername($options['username']);
        }
        if (isset($options['accessToken'])
        && $options['accessToken'] instanceof Zend_Oauth_Token_Access) {
            $this->setLocalHttpClient($options['accessToken']->getHttpClient($options));
        } else {
            $this->setLocalHttpClient(clone self::getHttpClient());
            if ($consumer === null) {
                $this->_oauthConsumer = new Zend_Oauth_Consumer($options);
            } else {
                $this->_oauthConsumer = $consumer;
            }
        }
    }


    /**
     * Overload of the Zend_Service_Twitter method
     * in order to not overwrite the path of the server
     * 
     * @param string $path 
     * @access protected
     * @return void
     */
    protected function _prepare( $path )
    {
        // Get the URI object and configure it
        if ( !$this->_uri instanceof Zend_Uri_Http )
        {
            throw new Zend_Rest_Client_Exception( 'URI object must be set before performing call' );
        }

        $uri = $this->_uri->getUri();

        if ( $path[0] != '/' && $uri[strlen( $uri )-1] != '/' )
        {
            $path = '/' . $path;
        }
        $this->_uri->setPath( $this->_uri->getPath() . $path );

        /**
         * Get the HTTP client and configure it for the endpoint URI.  Do this each time
         * because the Zend_Http_Client instance is shared among all Zend_Service_Abstract subclasses.
         */
        $this->_localHttpClient->resetParameters()->setUri( $this->_uri );
    }

    /**
     * Copy paste from Zend_Service_Twitter::statusUpdate() to customize the 
     * hardcoded $path variable for Identi.ca
     */
    public function statusUpdate($status, $inReplyToStatusId = null)
    {
        $this->_init();
        $path = '/statuses/update.xml';
        $len = iconv_strlen(htmlspecialchars($status, ENT_QUOTES, 'UTF-8'), 'UTF-8');
        if ($len > self::STATUS_MAX_CHARACTERS) {
            include_once 'Zend/Service/Twitter/Exception.php';
            throw new Zend_Service_Twitter_Exception(
                'Status must be no more than '
                . self::STATUS_MAX_CHARACTERS
                . ' characters in length'
            );
        } elseif (0 == $len) {
            include_once 'Zend/Service/Twitter/Exception.php';
            throw new Zend_Service_Twitter_Exception(
                'Status must contain at least one character'
            );
        }
        $data = array('status' => $status);
        if (is_numeric($inReplyToStatusId) && !empty($inReplyToStatusId)) {
            $data['in_reply_to_status_id'] = $inReplyToStatusId;
        }
        $response = $this->_post($path, $data);
        return new Zend_Rest_Client_Result($response->getBody());
    }

}

?>

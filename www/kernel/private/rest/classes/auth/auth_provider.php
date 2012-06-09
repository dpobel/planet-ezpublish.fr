<?php
/**
 * File containing ezpRestAuthProvider class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */
class ezpRestAuthProvider implements ezpRestProviderInterface
{
    /**
     * @see ezpRestProviderInterface::getRoutes()
     */
    public function getRoutes()
    {
        $routes = array(
            'basicAuth'    => new ezpMvcRailsRoute( '/http-basic-auth', 'ezpRestAuthController', 'basicAuth' ),
            'oauthLogin'   => new ezpMvcRailsRoute( '/oauth/login', 'ezpRestAuthController', 'oauthRequired' ),
            'oauthToken'   => new ezpMvcRailsRoute( '/oauth/token', 'ezpRestOauthTokenController', array( 'http-post' => 'handleRequest' ))
        );
        return $routes;
    }

        /**
     * Returns associated with provider view controller
     *
     * @return ezpRestViewController
     */
    public function getViewController()
    {
        return new ezpRestApiViewController();
    }
}
?>

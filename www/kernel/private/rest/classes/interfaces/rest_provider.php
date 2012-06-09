<?php
/**
 * File containing the ezpRestProviderInterface interface.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

interface ezpRestProviderInterface
{
    /**
     * Returns registered versioned routes for provider
     *
     * @abstract
     * @return array
     */
    public function getRoutes();

    /**
     * Returns associated with provider view controller
     *
     * @abstract
     * @return ezpRestViewController
     */
    public function getViewController();
}

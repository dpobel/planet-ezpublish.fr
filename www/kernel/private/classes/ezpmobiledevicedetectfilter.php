<?php
/**
 * File containing the ezpMobileDeviceDetectFilter class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

class ezpMobileDeviceDetectFilter
{
    /**
     * Returns an instance of the ezpMobileDeviceDetectFilterInterface class
     *
     * @static
     * @return ezpMobileDeviceDetectFilterInterface|null
     */
    public static function getFilter()
    {
        $mobileDeviceFilterClass = eZINI::instance()->variable( 'SiteAccessSettings', 'MobileDeviceFilterClass' );

        $mobileDeviceDetectFilter = class_exists( $mobileDeviceFilterClass) ? new $mobileDeviceFilterClass : null;

        if ( $mobileDeviceDetectFilter instanceof ezpMobileDeviceDetectFilterInterface )
            return $mobileDeviceDetectFilter;

        return null;
    }
}

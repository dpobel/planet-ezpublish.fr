<?php 
/**
 * File containing the eZIEImageFilterBW class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 1.1.0
 * @package ezie
 */

class eZIEImageFilterBW extends eZIEImageAction
{
    /**
     * Creates a black & white filter
     * 
     * @param  array(int) $region Affected region, as an array of 4 keys: x, y, w, h
     * 
     * @return array( ezcImageFilter ) 
     */
    static function filter( $region = null )
    {
        return array(
            new ezcImageFilter( 
                'colorspace',
                array( 
                    'space' => ezcImageColorspaceFilters::COLORSPACE_GREY,
                    'region' => $region, 
                )
            )
        );
    }
}

?>

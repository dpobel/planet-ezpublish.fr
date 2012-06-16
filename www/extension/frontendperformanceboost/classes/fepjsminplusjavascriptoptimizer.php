<?php
/**
 * @copyright Copyright (C) 2012 Damien Pobel. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @package frontendperformanceboost
 */

class fepJSMinPlusJavaScriptOptimizer extends fepOptimizer
{
    /**
     * Optimizes the JS string by using JSMinPlus PHP class
     *
     * @param string $code
     * @param int $level
     * @return string
     */
    public static function optimize( $code, $level = 2 )
    {

        eZDebug::accumulatorStart(
            __METHOD__, 'Packer',
            'Front end performance boost JS optimizer'
        );

        $res = JSMinPlus::minify( $code );

        self::report(
            strtolower( __CLASS__ ),
            __CLASS__,
            strlen( $code),
            strlen( $res )
        );


        eZDebug::accumulatorStop( __METHOD__ );
        return $res;
    }

}



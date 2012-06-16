<?php
/**
 * @copyright Copyright (C) 2012 Damien Pobel. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @package frontendperformanceboost
 */

class fepUglifyJavaScriptOptimizer extends fepCliOptimizer
{
    /**
     * Optimizes the JS string by using Uglify JS
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

        $optimizer = new self(
            eZINI::instance( 'ezjscore.ini' ), 'UglifyJS'
        );
        $res = $optimizer->execute( $code, $level );

        eZDebug::accumulatorStop( __METHOD__ );
        return $res;
    }

}



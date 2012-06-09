<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$Module = array( 'name' => 'eZLayout',
                 'variable_params' => true );

$ViewList = array();
$ViewList['set'] = array(
    'script' => 'set.php',
    'params' => array( 'LayoutStyle' ),
    );


?>

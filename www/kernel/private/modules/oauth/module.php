<?php
/**
 * File containing the oauthadmin module definition.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

include_once 'kernel/private/rest/classes/lazy.php';

$Module = array( 'name' => 'Rest client authorization',
                 'variable_params' => true );

$ViewList = array();

$ViewList['authorize'] = array(
    'script' => 'authorize.php',
);

$FunctionList = array( );
?>

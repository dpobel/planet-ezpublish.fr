<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$Module = array( "name" => "eZTrigger" );

$ViewList = array();
$ViewList["list"] = array(
    "script" => "list.php",
    'ui_context' => 'administration',
    "default_navigation_part" => 'ezsetupnavigationpart',
    "params" => array( ) );

?>

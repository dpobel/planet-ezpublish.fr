<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$NodeID = $Params['NodeID'];
$Module = $Params['Module'];


$tpl = eZTemplate::factory();

$Module->setTitle( "Error 404 object " . $NodeID . " not found" );

$tpl->setVariable( "object", $NodeID );

$Result = array();
$Result['content'] = $tpl->fetch( "design:content/error.tpl" );


?>

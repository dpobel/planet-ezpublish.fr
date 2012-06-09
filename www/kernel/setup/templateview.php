<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

// Redirect to visual module which is the correct place for this functionality
$module = $Params['Module'];
$parameters = $Params["Parameters"];

$visualModule = eZModule::exists( 'visual' );
if( $visualModule )
{
    return $module->forward( $visualModule, 'templateview', $parameters );
}

?>

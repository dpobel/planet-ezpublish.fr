<?php
/**
 * File containing the rest bootstrap
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

require 'autoload.php';
require 'kernel/private/rest/classes/lazy.php';

// Below we are setting up a minimal eZ Publish environment from the old index.php
// This is a temporary measure.

// We want PHP to deal with all errors here.
eZDebug::setHandleType( eZDebug::HANDLE_TO_PHP );
$GLOBALS['eZGlobalRequestURI'] = eZSys::serverVariable( 'REQUEST_URI' );
$ini = eZINI::instance();
eZSys::init( 'index.php', $ini->variable( 'SiteAccessSettings', 'ForceVirtualHost' ) == 'true' );
$uri = eZURI::instance( eZSys::requestURI() );
$GLOBALS['eZRequestedURI'] = $uri;

// load extensions
eZExtension::activateExtensions( 'default' );

// setup for eZSiteAccess:change() needs some methods defined in old index.php
// We disable it, since we dont' want any override settings to change the
// debug settings here
function eZUpdateDebugSettings() {}

// load siteaccess
$access = eZSiteAccess::match( $uri,
                      eZSys::hostname(),
                      eZSys::serverPort(),
                      eZSys::indexFile() );
$access = eZSiteAccess::change( $access );

// load siteaccess extensions
eZExtension::activateExtensions( 'access' );

// Now that all extensions are activated and siteaccess has been changed, reset
// all eZINI instances as they may not take into account siteaccess specific settings.
eZINI::resetAllInstances( false );

if( ezpRestDebug::isDebugEnabled() )
{
    $debug = ezpRestDebug::getInstance();
    $debug->updateDebugSettings();
}


$mvcConfig = new ezpMvcConfiguration();

$frontController = new ezpMvcConfigurableDispatcher( $mvcConfig );
$frontController->run();
?>

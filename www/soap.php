<?php
//
// Created on: <11-Oct-2004 15:41:12 kk>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.3.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file soap.php
*/

/*!
  \brief The SOAP file will handle all eZ Publish soap requests.

  SOAP functions are
*/

ob_start();

ini_set( "display_errors" , "0" );

// Set a default time zone if none is given. The time zone can be overriden
// in config.php or php.ini.
if ( !ini_get( "date.timezone" ) )
{
    date_default_timezone_set( "UTC" );
}

require 'autoload.php';

/*!
 Reads settings from site.ini and passes them to eZDebug.
*/
function eZUpdateDebugSettings()
{
    $ini = eZINI::instance();

    list( $debugSettings['debug-enabled'], $debugSettings['debug-by-ip'], $debugSettings['debug-by-user'], $debugSettings['debug-ip-list'], $debugSettings['debug-user-list'] ) =
        $ini->variableMulti( 'DebugSettings', array( 'DebugOutput', 'DebugByIP', 'DebugByUser', 'DebugIPList', 'DebugUserIDList' ), array ( 'enabled', 'enabled', 'enabled' ) );
    eZDebug::updateSettings( $debugSettings );
}

$ini = eZINI::instance();

// Initialize/set the index file.
eZSys::init( 'soap.php', $ini->variable( 'SiteAccessSettings', 'ForceVirtualHost' ) == 'true' );
$uri = eZURI::instance( eZSys::requestURI() );
$GLOBALS['eZRequestedURI'] = $uri;

// Check for extension
require_once( 'kernel/common/ezincludefunctions.php' );
eZExtension::activateExtensions( 'default' );
// Extension check end

// Activate correct siteaccess
require_once( 'access.php' );
$soapINI = eZINI::instance( 'soap.ini' );
if ( $soapINI->variable( 'GeneralSettings', 'UseDefaultAccess' ) === 'enabled' )
{
    $access = array( 'name' => $ini->variable( 'SiteSettings', 'DefaultAccess' ),
                     'type' => EZ_ACCESS_TYPE_DEFAULT );
}
else
{
    $access = accessType( $uri,
                          eZSys::hostname(),
                          eZSys::serverPort(),
                          eZSys::indexFile() );
}
$access = changeAccess( $access );
// Siteaccess activation end

// Check for activating Debug by user ID (Final checking. The first was in eZDebug::updateSettings())
eZDebug::checkDebugByUser();

// Check for siteaccess extension
eZExtension::activateExtensions( 'access' );
// Siteaccess extension check end

// reload soap.ini cache now that override paths have changed
$soapINI->loadCache();

/*!
 Reads settings from i18n.ini and passes them to eZTextCodec.
*/
function eZUpdateTextCodecSettings()
{
    $ini = eZINI::instance( 'i18n.ini' );

    list( $i18nSettings['internal-charset'], $i18nSettings['http-charset'], $i18nSettings['mbstring-extension'] ) =
        $ini->variableMulti( 'CharacterSettings', array( 'Charset', 'HTTPCharset', 'MBStringExtension' ), array( false, false, 'enabled' ) );

    eZTextCodec::updateSettings( $i18nSettings );
}

// Initialize text codec settings
eZUpdateTextCodecSettings();

// Initialize module loading
$moduleRepositories = eZModule::activeModuleRepositories();
eZModule::setGlobalPathList( $moduleRepositories );

// Load soap extensions
$enableSOAP = $soapINI->variable( 'GeneralSettings', 'EnableSOAP' );

if ( $enableSOAP == 'true' )
{
    eZSys::init( 'soap.php' );

    // Login if we have username and password.
    if ( eZHTTPTool::username() and eZHTTPTool::password() )
        eZUser::loginUser( eZHTTPTool::username(), eZHTTPTool::password() );

    $server = new eZSOAPServer();

    foreach( $soapINI->variable( 'ExtensionSettings', 'SOAPExtensions' ) as $extension )
    {
        include_once( eZExtension::baseDirectory() . '/' . $extension . '/soap/initialize.php' );
    }

    $server->processRequest();
}

ob_end_flush();

eZExecution::cleanExit();

?>

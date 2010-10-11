<?php
//
// Created on: <11-Aug-2003 13:10:28 bf>
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

$module = $Params['Module'];
$http = eZHTTPTool::instance();

if ( $http->hasPostVariable( 'Function' ) )
    $function = $http->postVariable( 'Function' );
else
    $function = $Params['Function'];

if ( $http->hasPostVariable( 'Key' ) )
    $key = $http->postVariable( 'Key' );
else
    $key = $Params['Key'];

    
if ( $http->hasPostVariable( 'Value' ) )
    $value = $http->postVariable( 'Value' );
else
    $value = $Params['Value'];

// Set user preferences
if ( eZOperationHandler::operationIsAvailable( 'user_preferences' ) )
{
    $operationResult = eZOperationHandler::execute( 'user',
                                                    'preferences', array( 'key'    => $key,
                                                                          'value'  => $value ) );
}
else
{
    eZPreferences::setValue( $key, $value );
}

// For use by ajax calls
if ( $function === 'set_and_exit' )
{
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}

if ( $http->hasPostVariable( 'RedirectURIAfterSet' ) )
{
    $url = $http->hasPostVariable( 'RedirectURIAfterSet' );
}
else
{
    // Extract URL to redirect to from user parameters.
    $urlArray = array_splice( $Params['Parameters'], 3 );
    foreach ( $urlArray as $key => $val ) // remove all the array elements that don't seem like URL parts
    {
        if ( !is_numeric( $key ) )
            unset( $urlArray[$key] );
    }
    $url = implode( '/', $urlArray );
    unset( $urlArray );
}

if ( $url )
{
    foreach ( array_keys( $Params['UserParameters'] ) as $key )
    {
        if ( $key == 'offset' )
            continue;
        $url .= '/(' . $key . ')/' . $Params['UserParameters'][$key];
    }
    $module->redirectTo( '/'.$url );
}
else if ( isset( $_SERVER['HTTP_REFERER'] ) )
{
    $preferredRedirectionURI = eZURI::decodeURL( $_SERVER['HTTP_REFERER'] );

    // We should exclude OFFSET from $preferredRedirectionURI
    $exploded = explode( '/', $preferredRedirectionURI );
    foreach ( array_keys( $exploded ) as $itemKey )
    {
        $item = $exploded[$itemKey];
        if ( $item == '(offset)' )
        {
            array_splice( $exploded, $itemKey, 2 );
            break;
        }
    }
    $redirectURI = implode( '/', $exploded );

    // Protect against redirect loop
    if ( strpos( $redirectURI, '/user/preferences/set'  ) !== false )
        $module->redirectTo( '/' );
    else
        eZRedirectManager::redirectTo( $module, /* $default = */ false, /* $view = */ true, /* $disallowed = */ false, $redirectURI );
    return;
}
else
{
    if ( $http->hasSessionVariable( 'LastAccessesURI' ) )
        $module->redirectTo( $http->sessionVariable( 'LastAccessesURI' ) );
    else
        $module->redirectTo( '/' );
}

?>

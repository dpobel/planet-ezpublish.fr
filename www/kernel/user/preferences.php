<?php
//
// Created on: <11-Aug-2003 13:10:28 bf>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
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

$module = $Params['Module'];
$http = eZHTTPTool::instance();
$function = $Params['Function'];
$key = $Params['Key'];
$value = $Params['Value'];

//include_once( 'kernel/classes/ezpreferences.php' );

eZPreferences::setValue( $key, $value );

// Extract URL to redirect to from user parameters.
$urlArray = array_splice( $Params['Parameters'], 3 );
foreach ( $urlArray as $key => $val ) // remove all the array elements that don't seem like URL parts
{
    if ( !is_numeric( $key ) )
        unset( $urlArray[$key] );
}
$url = implode( '/', $urlArray );
unset( $urlArray );

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
else
{
    //include_once( 'kernel/classes/ezredirectmanager.php' );
    //include_once( 'lib/ezutils/classes/ezuri.php' );

    $preferredRedirectionURI = isset( $_SERVER['HTTP_REFERER'] ) ? eZURI::decodeURL( $_SERVER['HTTP_REFERER'] ) : false;

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
    eZRedirectManager::redirectTo( $module, /* $default = */ false, /* $view = */ true, /* $disallowed = */ false, $redirectURI );
    return;
}

?>

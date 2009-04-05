<?php
//
// Created on: <23-Jan-2003 11:37:30 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.1.0
// BUILD VERSION: 23234
// COPYRIGHT NOTICE: Copyright (C) 1999-2009 eZ Systems AS
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

$Module = $Params['Module'];
$ViewMode = $Params['ViewMode'];

if( eZPreferences::value( 'admin_url_list_limit' ) )
{
    switch( eZPreferences::value( 'admin_url_list_limit' ) )
    {
        case '2': { $limit = 25; } break;
        case '3': { $limit = 50; } break;
        default:  { $limit = 10; } break;
    }
}
else
{
    $limit = 10;
}

$offset = $Params['Offset'];
if ( !is_numeric( $offset ) )
{
    $offset = 0;
}

if( $ViewMode != 'all' && $ViewMode != 'invalid' && $ViewMode != 'valid')
{
    $ViewMode = 'all';
}

if ( $Module->isCurrentAction( 'SetValid' ) )
{
    $urlSelection = $Module->actionParameter( 'URLSelection' );
    eZURL::setIsValid( $urlSelection, true );
}
else if ( $Module->isCurrentAction( 'SetInvalid' ) )
{
    $urlSelection = $Module->actionParameter( 'URLSelection' );
    eZURL::setIsValid( $urlSelection, false );
}


if( $ViewMode == 'all' )
{
    $listParameters = array( 'is_valid'       => null,
                             'offset'         => $offset,
                             'limit'          => $limit,
                             'only_published' => true );

    $countParameters = array( 'only_published' => true );
}
elseif( $ViewMode == 'valid' )
{
    $listParameters = array( 'is_valid'       => true,
                             'offset'         => $offset,
                             'limit'          => $limit,
                             'only_published' => true );

    $countParameters = array( 'is_valid' => true,
                              'only_published' => true );
}
elseif( $ViewMode == 'invalid' )
{
    $listParameters = array( 'is_valid'       => false,
                             'offset'         => $offset,
                             'limit'          => $limit,
                             'only_published' => true );

    $countParameters = array( 'is_valid' => false,
                              'only_published' => true );
}

$list = eZURL::fetchList( $listParameters );
$listCount = eZURL::fetchListCount( $countParameters );

$viewParameters = array( 'offset' => $offset, 'limit'  => $limit );

require_once( 'kernel/common/template.php' );
$tpl = templateInit();

$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'url_list', $list );
$tpl->setVariable( 'url_list_count', $listCount );
$tpl->setVariable( 'view_mode', $ViewMode );

$Result = array();
$Result['content'] = $tpl->fetch( "design:url/list.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'kernel/url', 'URL' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'kernel/url', 'List' ) ) );
?>

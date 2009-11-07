<?php
//
// Created on: <27-Aug-2002 16:31:33 bf>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.2.0
// BUILD VERSION: 24182
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

require_once( "kernel/common/template.php" );

$http = eZHTTPTool::instance();
$SectionID = $Params["SectionID"];
$Module = $Params['Module'];

if ( $SectionID == 0 )
{
    $section = array( 'id' => 0,
                      'name' => ezi18n( 'kernel/section', 'New section' ),
                      'navigation_part_identifier' => 'ezcontentnavigationpart' );
}
else
{
    $section = eZSection::fetch( $SectionID );
    if( $section === null )
    {
        return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
    }
}

if ( $http->hasPostVariable( "StoreButton" ) )
{
    if ( $SectionID == 0 )
    {
        $section = new eZSection( array() );
    }
    $section->setAttribute( 'name', $http->postVariable( 'Name' ) );
    $section->setAttribute( 'navigation_part_identifier', $http->postVariable( 'NavigationPartIdentifier' ) );
    if ( $http->hasPostVariable( 'Locale' ) )
        $section->setAttribute( 'locale', $http->postVariable( 'Locale' ) );
    $section->store();
    eZContentCacheManager::clearContentCacheIfNeededBySectionID( $section->attribute( 'id' ) );
    $Module->redirectTo( $Module->functionURI( 'list' ) );
    return;
}

if ( $http->hasPostVariable( 'CancelButton' )  )
{
    $Module->redirectTo( $Module->functionURI( 'list' ) );
}

$tpl = templateInit();

$tpl->setVariable( "section", $section );

$Result = array();
$Result['content'] = $tpl->fetch( "design:section/edit.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'kernel/section', 'Edit Section' ) ) );

?>

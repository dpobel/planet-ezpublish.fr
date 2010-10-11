<?php
//
// Created on: <16-Apr-2002 11:00:12 amos>
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

$Module = $Params['Module'];
$GroupID = null;
if ( isset( $Params["GroupID"] ) )
    $GroupID = $Params["GroupID"];

if ( is_numeric( $GroupID ) )
{
    $classgroup = eZContentClassGroup::fetch( $GroupID );
}
else
{
    $user = eZUser::currentUser();
    $user_id = $user->attribute( "contentobject_id" );
    $classgroup = eZContentClassGroup::create( $user_id );
    $classgroup->setAttribute( "name", ezpI18n::tr( 'kernel/class/groupedit', "New Group" ) );
    $classgroup->store();
    $GroupID = $classgroup->attribute( "id" );
    $Module->redirectTo( $Module->functionURI( "groupedit" ) . "/" . $GroupID );
    return;
}

$http = eZHTTPTool::instance();
if ( $http->hasPostVariable( "DiscardButton" ) )
{
    $Module->redirectTo( $Module->functionURI( "grouplist" ) );
    return;
}

if ( $http->hasPostVariable( "StoreButton" ) )
{
    if ( $http->hasPostVariable( "Group_name" ) )
    {
        $name = $http->postVariable( "Group_name" );
    }
    $classgroup->setAttribute( "name", $name );
    // Set new modification date
    $date_time = time();
    $classgroup->setAttribute( "modified", $date_time );
    $user = eZUser::currentUser();
    $user_id = $user->attribute( "contentobject_id" );
    $classgroup->setAttribute( "modifier_id", $user_id );
    $classgroup->store();

    eZContentClassClassGroup::update( null, $GroupID, $name );

    $Module->redirectToView( 'classlist', array( $classgroup->attribute( 'id' ) ) );
    return;
}

$Module->setTitle( "Edit class group " . $classgroup->attribute( "name" ) );

// Template handling
$tpl = eZTemplate::factory();

$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( "classgroup", $classgroup->attribute( "id" ) ) ) );

$tpl->setVariable( "http", $http );
$tpl->setVariable( "module", $Module );
$tpl->setVariable( "classgroup", $classgroup );

$Result = array();
$Result['content'] = $tpl->fetch( "design:class/groupedit.tpl" );
$Result['path'] = array( array( 'url' => '/class/grouplist/',
                                'text' => ezpI18n::tr( 'kernel/class', 'Class groups' ) ),
                         array( 'url' => false,
                                'text' => $classgroup->attribute( 'name' ) ) );

?>

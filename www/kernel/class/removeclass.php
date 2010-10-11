<?php
//
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
$http = eZHTTPTool::instance();
$deleteIDArray = $http->hasSessionVariable( 'DeleteClassIDArray' ) ? $http->sessionVariable( 'DeleteClassIDArray' ) : array();
$DeleteResult = array();
$alreadyRemoved = array();

if ( !$http->hasPostVariable( 'ConfirmButton' ) && !$http->hasPostVariable( 'CancelButton' ) && $GroupID != null )
{
    // we will remove class - group relations rather than classes if they belongs to more than 1 group:
    $updateDeleteIDArray = true;
    foreach ( $deleteIDArray as $key => $classID )
    {
        // for each classes tagged for deleting:
        $class = eZContentClass::fetch( $classID );
        if ( $class )
        {
            // find out to how many groups the class belongs:
            $classInGroups = $class->attribute( 'ingroup_list' );
            if ( count( $classInGroups ) != 1 )
            {
                // remove class - group relation:
                eZClassFunctions::removeGroup( $classID, null, array( $GroupID ) );
                $alreadyRemoved[] = array( 'id' => $classID,
                                           'name' => $class->attribute( 'name' ) );
                $updateDeleteIDArray = true;
                unset( $deleteIDArray[$key] );
            }
        }
    }
    if ( $updateDeleteIDArray )
    {
        // we aren't going to remove classes already processed:
        $http->setSessionVariable( 'DeleteClassIDArray', $deleteIDArray );
    }
    if ( count( $deleteIDArray ) == 0 )
    {
        // we don't need anything to confirm:
        return $Module->redirectTo( '/class/classlist/' . $GroupID );
    }
}

if ( $http->hasPostVariable( "ConfirmButton" ) )
{
    foreach ( $deleteIDArray as $deleteID )
    {
        eZContentClassOperations::remove( $deleteID );
    }
    return $Module->redirectTo( '/class/classlist/' . $GroupID );
}
if ( $http->hasPostVariable( "CancelButton" ) )
{
    return $Module->redirectTo( '/class/classlist/' . $GroupID );
}

$canRemoveCount = 0;
foreach ( $deleteIDArray as $deleteID )
{
    $ClassObjectsCount = 0;
    $class = eZContentClass::fetch( $deleteID );
    if ( $class != null )
    {
        $class = eZContentClass::fetch( $deleteID );
        $ClassID = $class->attribute( 'id' );
        $ClassName = $class->attribute( 'name' );
        if ( !$class->isRemovable() )
        {
            $item = array( "className" => $ClassName,
                           'objectCount' => 0,
                           "is_removable" => false,
                           'reason' => $class->removableInformation() );
            $DeleteResult[] = $item;
            continue;
        }
        ++$canRemoveCount;
        $classObjects = eZContentObject::fetchSameClassList( $ClassID );
        $ClassObjectsCount = count( $classObjects );
        $item = array( "className" => $ClassName,
                       "is_removable" => true,
                       "objectCount" => $ClassObjectsCount );
        $DeleteResult[] = $item;
    }
}

$canRemove = ( $canRemoveCount > 0 );

$Module->setTitle( ezpI18n::tr( 'kernel/class', 'Remove classes %class_id', null, array( '%class_id' => $ClassID ) ) );
$tpl = eZTemplate::factory();

$tpl->setVariable( 'module', $Module );
$tpl->setVariable( 'GroupID', $GroupID );
$tpl->setVariable( 'DeleteResult', $DeleteResult );
$tpl->setVariable( 'already_removed', $alreadyRemoved );
$tpl->setVariable( 'can_remove', $canRemove );

$Result = array();
$Result['content'] = $tpl->fetch( "design:class/removeclass.tpl" );
$Result['path'] = array( array( 'url' => '/class/grouplist/',
                                'text' => ezpI18n::tr( 'kernel/class', 'Class groups' ) ) );
$Result['path'][] = array( 'url' => false,
                           'text' => ezpI18n::tr( 'kernel/class', 'Remove classes' ) );
?>

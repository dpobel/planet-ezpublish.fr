<?php
//
// Created on: <18-Nov-2003 10:00:08 amos>
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

//include_once( "kernel/classes/ezcontentclass.php" );
//include_once( "kernel/classes/ezcontentclassattribute.php" );
//include_once( "kernel/classes/ezcontentclassclassgroup.php" );

$Module = $Params['Module'];
$LanguageCode = $Params['Language'];
$http = eZHTTPTool::instance();
$ClassID = null;
$validation = array( 'processed' => false,
                     'groups' => array() );

if ( isset( $Params["ClassID"] ) )
    $ClassID = $Params["ClassID"];
$ClassVersion = null;

if ( !is_numeric( $ClassID ) )
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );

$class = eZContentClass::fetch( $ClassID, true, eZContentClass::VERSION_STATUS_DEFINED );

if ( !$class )
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

if ( !$LanguageCode)
    $LanguageCode = $class->attribute( 'top_priority_language_locale' );

if ( $http->hasPostVariable( 'AddGroupButton' ) && $http->hasPostVariable( 'ContentClass_group' ) )
{
    //include_once( "kernel/class/ezclassfunctions.php" );
    eZClassFunctions::addGroup( $ClassID, $ClassVersion, $http->postVariable( 'ContentClass_group' ) );
}

if ( $http->hasPostVariable( 'RemoveGroupButton' ) && $http->hasPostVariable( 'group_id_checked' ) )
{
    //include_once( "kernel/class/ezclassfunctions.php" );
    if ( !eZClassFunctions::removeGroup( $ClassID, $ClassVersion, $http->postVariable( 'group_id_checked' ) ) )
    {
        $validation['groups'][] = array( 'text' => ezi18n( 'kernel/class', 'You have to have at least one group that the class belongs to!' ) );
        $validation['processed'] = true;
    }
}
else if ( $http->hasPostVariable( 'SetSorting' ) &&
          $http->hasPostVariable( 'ContentClass_default_sorting_exists' ) )
{
    $db = eZDB::instance();
    $db->begin();
    if ( $http->hasPostVariable( 'ContentClass_default_sorting_field' ) )
    {
        $sortingField = $http->postVariable( 'ContentClass_default_sorting_field' );
        $class->setAttribute( 'sort_field', $sortingField );
    }
    if ( $http->hasPostVariable( 'ContentClass_default_sorting_order' ) )
    {
        $sortingOrder = $http->postVariable( 'ContentClass_default_sorting_order' );
        $class->setAttribute( 'sort_order', $sortingOrder );
    }
    $class->store();
    $db->commit();
}

$attributes = $class->fetchAttributes();
//include_once( "kernel/classes/ezdatatype.php" );
$datatypes = eZDataType::registeredDataTypes();

$mainGroupID = false;
$mainGroupName = false;
$groupList = $class->fetchGroupList();
if ( count( $groupList ) > 0 )
{
    $mainGroupID = $groupList[0]->attribute( 'group_id' );
    $mainGroupName = $groupList[0]->attribute( 'group_name' );
}

$Module->setTitle( "Edit class " . $class->attribute( "name" ) );

require_once( "kernel/common/template.php" );
$tpl = templateInit();

$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( 'class', $class->attribute( "id" ) ),
                      array( 'class_identifier', $class->attribute( 'identifier' ) ) ) );

$tpl->setVariable( 'module', $Module );
$tpl->setVariable( 'language_code', $LanguageCode );
$tpl->setVariable( 'class', $class );
$tpl->setVariable( 'attributes', $attributes );
$tpl->setVariable( 'datatypes', $datatypes );
$tpl->setVariable( 'validation', $validation );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:class/view.tpl' );
$Result['path'] = array( array( 'url' => '/class/grouplist/',
                                'text' => ezi18n( 'kernel/class', 'Classes' ) ) );
if ( $mainGroupID !== false )
{
    $Result['path'][] = array( 'url' => '/class/classlist/' . $mainGroupID,
                               'text' => $mainGroupName );
}
$Result['path'][] = array( 'url' => false,
                           'text' => $class->attribute( 'name' ) );

?>

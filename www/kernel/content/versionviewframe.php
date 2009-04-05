<?php
//
// Created on: <21-Nov-2004 21:58:43 hovik>
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

/*! \file
*/

/* Module action checks */
if ( $Module->isCurrentAction( 'Edit' ) and
     $versionObject->attribute( 'status' ) == eZContentObjectVersion::STATUS_DRAFT and
     $contentObject->attribute( 'can_edit' ) and
     $isCreator )
{
    return $Module->redirectToView( 'edit', array( $ObjectID, $EditVersion, $LanguageCode ) );
}

// If we have an archived version editing we cannot edit the version directly.
// Instead we redirect to the edit page without a version, this will create
// a new version for us and start the edit operation
if ( $Module->isCurrentAction( 'Edit' ) and
     $contentObject->attribute( 'status' ) == eZContentObject::STATUS_ARCHIVED and
     $contentObject->attribute( 'can_edit' ) )
{
    return $Module->redirectToView( 'edit', array( $ObjectID, false, $LanguageCode, $FromLanguage ) );
}

if ( $Module->isCurrentAction( 'Publish' ) and
     $versionObject->attribute( 'status' ) == eZContentObjectVersion::STATUS_DRAFT and
     $contentObject->attribute( 'can_edit' ) and
     $isCreator )
{
    $conflictingVersions = $versionObject->hasConflicts( $LanguageCode );
    if ( $conflictingVersions )
    {
        require_once( 'kernel/common/template.php' );
        $tpl = templateInit();

        $res = eZTemplateDesignResource::instance();
        $res->setKeys( array( array( 'object', $contentObject->attribute( 'id' ) ),
                            array( 'remote_id', $contentObject->attribute( 'remote_id' ) ),
                            array( 'class', $class->attribute( 'id' ) ),
                            array( 'class_identifier', $class->attribute( 'identifier' ) ),
                            array( 'class_group', $class->attribute( 'match_ingroup_id_list' ) ) ) );

        $tpl->setVariable( 'edit_language', $LanguageCode );
        $tpl->setVariable( 'current_version', $versionObject->attribute( 'version' ) );
        $tpl->setVariable( 'object', $contentObject );
        $tpl->setVariable( 'draft_versions', $conflictingVersions );

        $Result = array();
        $Result['content'] = $tpl->fetch( 'design:content/edit_conflict.tpl' );
        $section = eZSection::fetch( $contentObject->attribute( 'section_id' ) );
        if ( $section )
        {
            $Result['navigation_part'] = $section->attribute( 'navigation_part_identifier' );
            $Result['section_id'] = $section->attribute( 'id' );
        }
        $Result['path'] = array( array( 'text' => ezi18n( 'kernel/content', 'Version preview' ),
                                        'url' => false ) );
        return $Result;
    }

    $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $ObjectID,
                                                                                 'version' => $EditVersion ) );
    $object = eZContentObject::fetch( $ObjectID );
    $http = eZHTTPTool::instance();
    if ( $object->attribute( 'main_node_id' ) != null )
    {
        if ( $http->hasSessionVariable( 'ParentObject' ) && $http->sessionVariable( 'NewObjectID' ) == $object->attribute( 'id' ) )
        {
            $parentArray = $http->sessionVariable( 'ParentObject' );
            $parentURL = $Module->redirectionURI( 'content', 'edit', $parentArray );
            $parentObject = eZContentObject::fetch( $parentArray[0] );
            $parentObject->addContentObjectRelation( $object->attribute( 'id' ), $parentArray[1] );
            $http->removeSessionVariable( 'ParentObject' );
            $http->removeSessionVariable( 'NewObjectID' );
            $Module->redirectTo( $parentURL );
        }
        else
        {
            $Module->redirectToView( 'view', array( 'full', $object->attribute( 'main_parent_node_id' ) ) );
        }
    }
    else
    {
        $Module->redirectToView( 'view', array( 'sitemap', 2 ) );
    }

    return;
}

$contentObject->setAttribute( 'current_version', $EditVersion );

$ini = eZINI::instance();

$siteaccess = $ini->variable( 'SiteSettings', 'DefaultAccess' );
if ( $Module->hasActionParameter( 'SiteAccess' ) )
{
    $siteaccess = $Module->actionParameter( 'SiteAccess' );
}

if ( $LanguageCode )
{
    $oldLanguageCode = $node->currentLanguage();
    $oldObjectLanguageCode = $contentObject->currentLanguage();
    $node->setCurrentLanguage( $LanguageCode );
    $contentObject->setCurrentLanguage( $LanguageCode );
}
$tpl->setVariable( 'site_access_list', $ini->variable( 'SiteAccessSettings', 'RelatedSiteAccessList' ) );
$tpl->setVariable( 'node', $node );
$tpl->setVariable( 'object', $contentObject );
$tpl->setVariable( 'version', $versionObject );
$tpl->setVariable( 'language', $LanguageCode );
$tpl->setVariable( 'object_languagecode', $LanguageCode );
$tpl->setVariable( 'siteaccess', $siteaccess );
$tpl->setVariable( 'is_creator', $isCreator );
$tpl->setVariable( 'from_language', $FromLanguage );

$res = eZTemplateDesignResource::instance();

$section = eZSection::fetch( $contentObject->attribute( 'section_id' ) );
if ( $section )
    $navigationPartIdentifier = $section->attribute( 'navigation_part_identifier' );
else
    $navigationPartIdentifier = null;

$keyArray = array( array( 'object', $contentObject->attribute( 'id' ) ),
                   array( 'node', $node->attribute( 'node_id' ) ),
                   array( 'parent_node', $node->attribute( 'parent_node_id' ) ),
                   array( 'class', $contentObject->attribute( 'contentclass_id' ) ),
                   array( 'class_identifier', $node->attribute( 'class_identifier' ) ),
                   array( 'viewmode', 'full' ),
                   array( 'remote_id', $contentObject->attribute( 'remote_id' ) ),
                   array( 'node_remote_id', $node->attribute( 'remote_id' ) ),
                   array( 'navigation_part_identifier', $navigationPartIdentifier ),
                   array( 'depth', $node->attribute( 'depth' ) ),
                   array( 'url_alias', $node->attribute( 'url_alias' ) ),
                   array( 'class_group', $contentObject->attribute( 'match_ingroup_id_list' ) ),
                   array( 'state', $contentObject->attribute( 'state_id_array' ) ),
                   array( 'state_identifier', $contentObject->attribute( 'state_identifier_array' ) ) );

$parentNode = $node->attribute( 'parent' );
if ( is_object( $parentNode ) )
{
    $parentObject = $parentNode->attribute( 'object' );
    if ( is_object( $parentObject ) )
    {
        $keyArray[] = array( 'parent_class', $parentObject->attribute( 'contentclass_id' ) );
        $keyArray[] = array( 'parent_class_identifier', $parentObject->attribute( 'class_identifier' ) );
    }
}

$parents = $node->attribute( 'path' );
$path = array();
$titlePath = array();
foreach ( $parents as $parent )
{
    $path[] = array( 'text' => $parent->attribute( 'name' ),
                     'url' => '/content/view/full/' . $parent->attribute( 'node_id' ),
                     'url_alias' => $parent->attribute( 'url_alias' ),
                     'node_id' => $parent->attribute( 'node_id' ) );
}

$titlePath = $path;
$path[] = array( 'text' => $contentObject->attribute( 'name' ),
                 'url' => false,
                 'url_alias' => false,
                 'node_id' => $node->attribute( 'node_id' ) );

$titlePath[] = array( 'text' => $contentObject->attribute( 'name' ),
                      'url' => false,
                      'url_alias' => false );

$tpl->setVariable( 'node_path', $path );


$res->setKeys( $keyArray );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:content/view/versionview.tpl' );
$Result['node_id'] = $node->attribute( 'node_id' );
$Result['path'] = $path;
$Result['title_path'] = $titlePath;

$Result['navigation_part'] = $navigationPartIdentifier;
$Result['section_id'] = $contentObject->attribute( 'section_id' );

if ( $LanguageCode )
{
    $node->setCurrentLanguage( $oldLanguageCode );
    $contentObject->setCurrentLanguage( $oldObjectLanguageCode );
}

return $Result;


?>

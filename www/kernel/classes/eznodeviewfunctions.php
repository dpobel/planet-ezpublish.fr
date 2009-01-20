<?php
//
// Definition of eZNodeviewfunctions class
//
// Created on: <20-Apr-2004 11:57:36 bf>
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

/*!
  \class eZNodeviewfunctions eznodeviewfunctions.php
  \brief The class eZNodeviewfunctions does

*/

class eZNodeviewfunctions
{
    // Deprecated function for generating the view cache
    static function generateNodeView( $tpl, $node, $object, $languageCode, $viewMode, $offset,
                                      $cacheDir, $cachePath, $viewCacheEnabled,
                                      $viewParameters = array( 'offset' => 0, 'year' => false, 'month' => false, 'day' => false ),
                                      $collectionAttributes = false, $validation = false )
    {
        require_once( 'kernel/classes/ezclusterfilehandler.php' );
        $cacheFile = eZClusterFileHandler::instance( $cachePath );
        $args = compact( "tpl", "node", "object", "languageCode", "viewMode", "offset",
                         "viewCacheEnabled",
                         "viewParameters",
                         "collectionAttributes", "validation" );
        $Result = $cacheFile->processCache( null, // no retrieve, only generate is called
                                            array( 'eZNodeviewfunctions', 'generateCallback' ),
                                            null,
                                            null,
                                            $args );
        return $Result;
    }

    // Note: This callback is needed to generate the array which is returned
    //       back to eZClusterFileHandler for processing.
    static function generateCallback( $file, $args )
    {
        $res = call_user_func_array( array( 'eZNodeviewfunctions', 'generateNodeViewData' ),
                                     $args );

        // Check if cache time = 0 (viewcache disabled)
        $store = $res['cache_ttl'] != 0;
        // or if explicitly turned off
        if ( !$args['viewCacheEnabled'] )
            $store = false;
        $retval = array( 'content' => $res,
                         'scope'   => 'viewcache',
                         'store'   => $store );
        if ( $store )
            $retval['binarydata'] = serialize( $res );

        return $retval;
    }

    static function generateNodeViewData( $tpl, $node, $object, $languageCode, $viewMode, $offset,
                                          $viewParameters = array( 'offset' => 0, 'year' => false, 'month' => false, 'day' => false ),
                                          $collectionAttributes = false, $validation = false )
    {
        //include_once( 'kernel/classes/ezsection.php' );
        eZSection::setGlobalID( $object->attribute( 'section_id' ) );

        $section = eZSection::fetch( $object->attribute( 'section_id' ) );
        if ( $section )
            $navigationPartIdentifier = $section->attribute( 'navigation_part_identifier' );
        else
            $navigationPartIdentifier = null;

        $keyArray = array( array( 'object', $object->attribute( 'id' ) ),
                           array( 'node', $node->attribute( 'node_id' ) ),
                           array( 'parent_node', $node->attribute( 'parent_node_id' ) ),
                           array( 'class', $object->attribute( 'contentclass_id' ) ),
                           array( 'class_identifier', $node->attribute( 'class_identifier' ) ),
                           array( 'view_offset', $offset ),
                           array( 'viewmode', $viewMode ),
                           array( 'navigation_part_identifier', $navigationPartIdentifier ),
                           array( 'depth', $node->attribute( 'depth' ) ),
                           array( 'url_alias', $node->attribute( 'url_alias' ) ),
                           array( 'class_group', $object->attribute( 'match_ingroup_id_list' ) ) );

        $parentClassID = false;
        $parentClassIdentifier = false;
        $parentNode = $node->attribute( 'parent' );
        if ( is_object( $parentNode ) )
        {
            $parentObject = $parentNode->attribute( 'object' );
            if ( is_object( $parentObject ) )
            {
                $parentClass = $parentObject->contentClass();
                if ( is_object( $parentClass ) )
                {
                    $parentClassID = $parentClass->attribute( 'id' );
                    $parentClassIdentifier = $parentClass->attribute( 'identifier' );

                    $keyArray[] = array( 'parent_class', $parentClassID );
                    $keyArray[] = array( 'parent_class_identifier', $parentClassIdentifier );
                }
            }
        }

        $res = eZTemplateDesignResource::instance();
        $res->setKeys( $keyArray );

        if ( $languageCode )
        {
            $oldLanguageCode = $node->currentLanguage();
            $node->setCurrentLanguage( $languageCode );
        }

        $tpl->setVariable( 'node', $node );
        $tpl->setVariable( 'viewmode', $viewMode );
        $tpl->setVariable( 'language_code', $languageCode );
        $tpl->setVariable( 'view_parameters', $viewParameters );
        $tpl->setVariable( 'collection_attributes', $collectionAttributes );
        $tpl->setVariable( 'validation', $validation );
        $tpl->setVariable( 'persistent_variable', false );

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
        $path[] = array( 'text' => $object->attribute( 'name' ),
                         'url' => false,
                         'url_alias' => false,
                         'node_id' => $node->attribute( 'node_id' ) );

        $titlePath[] = array( 'text' => $object->attribute( 'name' ),
                              'url' => false,
                              'url_alias' => false );

        $tpl->setVariable( 'node_path', $path );

        $Result = array();
        $Result['content'] = $tpl->fetch( 'design:node/view/' . $viewMode . '.tpl' );
        $Result['view_parameters'] = $viewParameters;
        $Result['path'] = $path;
        $Result['title_path'] = $titlePath;
        $Result['section_id'] = $object->attribute( 'section_id' );
        $Result['node_id'] = $node->attribute( 'node_id' );
        $Result['navigation_part'] = $navigationPartIdentifier;

        $contentInfoArray = array();
        $contentInfoArray['object_id'] = $object->attribute( 'id' );
        $contentInfoArray['node_id'] = $node->attribute( 'node_id' );
        $contentInfoArray['parent_node_id'] =  $node->attribute( 'parent_node_id' );
        $contentInfoArray['class_id'] = $object->attribute( 'contentclass_id' );
        $contentInfoArray['class_identifier'] = $node->attribute( 'class_identifier' );
        $contentInfoArray['offset'] = $offset;
        $contentInfoArray['viewmode'] = $viewMode;
        $contentInfoArray['navigation_part_identifier'] = $navigationPartIdentifier;
        $contentInfoArray['node_depth'] = $node->attribute( 'depth' );
        $contentInfoArray['url_alias'] = $node->attribute( 'url_alias' );
        $contentInfoArray['persistent_variable'] = false;
        if ( $tpl->variable( 'persistent_variable' ) !== false )
        {
            $contentInfoArray['persistent_variable'] = $tpl->variable( 'persistent_variable' );
            $keyArray[] = array( 'persistent_variable', $contentInfoArray['persistent_variable'] );
            $res->setKeys( $keyArray );
        }
        $contentInfoArray['class_group'] = $object->attribute( 'match_ingroup_id_list' );
        $contentInfoArray['parent_class_id'] = $parentClassID;
        $contentInfoArray['parent_class_identifier'] = $parentClassIdentifier;

        $Result['content_info'] = $contentInfoArray;

        // Store which templates were used to make this cache.
        $Result['template_list'] = $tpl->templateFetchList();

        // Check if time to live is set in template
        if ( $tpl->hasVariable( 'cache_ttl' ) )
        {
            $cacheTTL = $tpl->variable( 'cache_ttl' );
        }

        if ( !isset( $cacheTTL ) )
        {
            $cacheTTL = -1;
        }

/*
// This checking is now handled outside of this function.
        // Check if cache time = 0 (disabled)
        if ( $cacheTTL == 0 )
        {
            $viewCacheEnabled = false;
        }
*/

        $Result['cache_ttl'] = $cacheTTL;

/*
// File storage is now handled outside of this function
        // Store view cache
        if ( $viewCacheEnabled )
        {
            $serializeString = serialize( $Result );

            //include_once( "lib/ezfile/classes/ezatomicfile.php" );
            $cacheFile = new eZAtomicFile( $cachePath );
            $cacheFile->write( $serializeString );
            $cacheFile->close();

            // VS-DBFILE

            require_once( 'kernel/classes/ezclusterfilehandler.php' );
            $fileHandler = eZClusterFileHandler::instance();
            $fileHandler->fileStore( $cachePath, 'viewcache', true );
        }
*/

        if ( $languageCode )
        {
            $node->setCurrentLanguage( $oldLanguageCode );
        }

        return $Result;
    }

    static function generateViewCacheFile( $user, $nodeID, $offset, $layout, $language, $viewMode, $viewParameters = false, $cachedViewPreferences = false )
    {
        //include_once( 'kernel/classes/ezuserdiscountrule.php' );
        //include_once( 'kernel/classes/ezpreferences.php' );

        $limitedAssignmentValueList = $user->limitValueList();
        $roleList = $user->roleIDList();
        $discountList = eZUserDiscountRule::fetchIDListByUserID( $user->attribute( 'contentobject_id' ) );

        if ( !$language )
        {
            $language = false;
        }
        $currentSiteAccess = $GLOBALS['eZCurrentAccess']['name'];

        $cacheHashArray = array( $nodeID,
                                 $viewMode,
                                 $language,
                                 $offset,
                                 $layout,
                                 implode( '.', $roleList ),
                                 implode( '.', $limitedAssignmentValueList),
                                 implode( '.', $discountList ),
                                 eZSys::indexFile() );

        // Make the cache unique for every case of view parameters
        if ( $viewParameters )
        {
            $vpString = "";
            ksort( $viewParameters );
            foreach ( $viewParameters as $key => $value )
            {
                if ( !$key )
                    continue;
                $vpString .= 'vp:' . $key . '=' . $value;
            }
            $cacheHashArray[] = $vpString;
        }

        // Make the cache unique for every case of the preferences
        if ( $cachedViewPreferences === false )
        {
            $siteIni = eZINI::instance( );
            $depPreferences = $siteIni->variable( 'ContentSettings', 'CachedViewPreferences' );
        }
        else
        {
            $depPreferences = $cachedViewPreferences;
        }
        if ( isset ( $depPreferences[$viewMode] ) )
        {
            $depPreferences = explode( ';', $depPreferences[$viewMode] );
            $pString = "";
            // Fetch preferences for the specified user
            $preferences = eZPreferences::values( $user );
            foreach( $depPreferences as $pref )
            {
                $pref = explode( '=', $pref );
                if ( isset( $pref[0] ) )
                {
                    if ( isset( $preferences[$pref[0]] ) )
                        $pString .= 'p:' . $pref[0] . '='. $preferences[$pref[0]]. ';';
                    else if ( isset( $pref[1] ) )
                        $pString .= 'p:' . $pref[0] . '='. $pref[1]. ';';
                }
            }
            $cacheHashArray[] = $pString;
        }

        $ini = eZINI::instance();

        $cacheFile = $nodeID . '-' . md5( implode( '-', $cacheHashArray ) ) . '.cache';
        $extraPath = eZDir::filenamePath( $nodeID );
        $cacheDir = eZDir::path( array( eZSys::cacheDirectory(), $ini->variable( 'ContentSettings', 'CacheDir' ), $currentSiteAccess, $extraPath ) );
        $cachePath = eZDir::path( array( $cacheDir, $cacheFile ) );

        return array( 'cache_path' => $cachePath,
                      'cache_dir' => $cacheDir,
                      'cache_file' => $cacheFile );
    }


    static function contentViewRetrieve( $file, $mtime, $args )
    {
        extract( $args );

        $cacheExpired = false;

        // Read Cache file
        if ( !eZContentObject::isCacheExpired( $mtime ) )
        {
//        $contents = $cacheFile->fetchContents();
            $contents = file_get_contents( $file );
            $Result = unserialize( $contents );

            // Check if cache has expired when cache_ttl is set
            $cacheTTL = isset( $Result['cache_ttl'] ) ? $Result['cache_ttl'] : -1;
            if ( $cacheTTL > 0 )
            {
                $expiryTime = $mtime + $cacheTTL;
                if ( time() > $expiryTime )
                {
                    $cacheExpired = true;
                    $expiryReason = 'Content cache is expired by cache_ttl=' . $cacheTTL;
                }
            }

            // Check if template source files are newer, but only if the cache is not expired
            if ( !$cacheExpired )
            {
                $developmentModeEnabled = $ini->variable( 'TemplateSettings', 'DevelopmentMode' ) == 'enabled';
                // Only do filemtime checking when development mode is enabled.
                if ( $developmentModeEnabled &&
                     isset( $Result['template_list'] ) ) // And only if there is a list stored in the cache
                {
                    foreach ( $Result['template_list'] as $templateFile )
                    {
                        if ( @filemtime( $templateFile ) > $mtime )
                        {
                            $cacheExpired = true;
                            $expiryReason = "Content cache is expired by template file '" . $templateFile . "'";
                            break;
                        }
                    }
                }
            }

            if ( !$cacheExpired )
            {
                $keyArray = array( array( 'object', $Result['content_info']['object_id'] ),
                                   array( 'node', $Result['content_info']['node_id'] ),
                                   array( 'parent_node', $Result['content_info']['parent_node_id'] ),
                                   array( 'class', $Result['content_info']['class_id'] ),
                                   array( 'view_offset', $Result['content_info']['offset'] ),
                                   array( 'navigation_part_identifier', $Result['content_info']['navigation_part_identifier'] ),
                                   array( 'viewmode', $Result['content_info']['viewmode'] ),
                                   array( 'depth', $Result['content_info']['node_depth'] ),
                                   array( 'url_alias', $Result['content_info']['url_alias'] ),
                                   array( 'persistent_variable', $Result['content_info']['persistent_variable'] ),
                                   array( 'class_group', $Result['content_info']['class_group'] ),
                                   array( 'parent_class_id', $Result['content_info']['parent_class_id'] ),
                                   array( 'parent_class_identifier', $Result['content_info']['parent_class_identifier'] ) );

                if ( isset( $Result['content_info']['class_identifier'] ) )
                    $keyArray[] = array( 'class_identifier', $Result['content_info']['class_identifier'] );

                $res = eZTemplateDesignResource::instance();
                $res->setKeys( $keyArray );

                // set section id
                //include_once( 'kernel/classes/ezsection.php' );
                eZSection::setGlobalID( $Result['section_id'] );

                return $Result;
            }
        }
        else
        {
            $expiryReason = 'Content cache is expired by eZContentObject::isCacheExpired(' . $mtime . ")";
        }

        // Cache is expired so return specialized cluster object
        if ( !isset( $expiryReason ) )
            $expiryReason = 'Content cache is expired';
        //include_once( 'kernel/classes/ezclusterfilefailure.php' );
        return new eZClusterFileFailure( 1, $expiryReason );
    }

    static function contentViewGenerate( $file, $args )
    {
        extract( $args );
        $node = eZContentObjectTreeNode::fetch( $NodeID );

        if ( !is_object( $node ) )
        {
            return  array( 'content' => $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' ),
                           'store'   => false );
        }

        $object = $node->attribute( 'object' );

        if ( !is_object( $object ) )
        {
            return  array( 'content' => $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' ),
                           'store'   => false );
        }

        if ( !$object instanceof eZContentObject )
        {
            return  array( 'content' => $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' ),
                           'store'   => false );
        }
        if ( $node === null )
        {
            return  array( 'content' => $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' ),
                           'store'   => false );
        }

        if ( $object === null )
        {
            return  array( 'content' => $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' ),
                           'store'   => false );
        }

        if ( $node->attribute( 'is_invisible' ) && !eZContentObjectTreeNode::showInvisibleNodes() )
        {
            return array( 'content' => $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' ),
                          'store'   => false );
        }

//    if ( !$object->attribute( 'can_read' ) )
        if ( !$object->canRead() )
        {
            return array( 'content' => $Module->handleError( eZError::KERNEL_ACCESS_DENIED,
                                                             'kernel',
                                                             array( 'AccessList' => $object->accessList( 'read' ) ) ),
                          'store'   => false );
        }

        $Result = eZNodeviewfunctions::generateNodeViewData( $tpl, $node, $object,
                                                              $LanguageCode, $ViewMode, $Offset,
                                                              $viewParameters, $collectionAttributes,
                                                              $validation );
        $retval = array( 'content' => $Result,
                         'scope'   => 'viewcache',
                         'store'   => $Result['cache_ttl'] != 0 );
        if ( $file !== false && $retval['store'] )
            $retval['binarydata'] = serialize( $Result );
        return $retval;
    }
}

?>

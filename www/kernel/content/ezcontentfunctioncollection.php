<?php
//
// Definition of eZContentFunctionCollection class
//
// Created on: <06-Oct-2002 16:19:31 amos>
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

/*!
  \class eZContentFunctionCollection ezcontentfunctioncollection.php
  \brief The class eZContentFunctionCollection does

*/

class eZContentFunctionCollection
{
    /*!
     Constructor
    */
    function eZContentFunctionCollection()
    {
    }

    function fetchContentObject( $objectID, $remoteID = false )
    {
        if ( $objectID ===false && $remoteID !== false )
        {
            $contentObject = eZContentObject::fetchByRemoteID( $remoteID );
        }
        else
        {
            $contentObject = eZContentObject::fetch( $objectID );
        }
        
        if ( $contentObject === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $contentObject );
        }

        return $result;
    }

    function fetchContentVersion( $objectID, $versionID )
    {
        $contentVersion = eZContentObjectVersion::fetchVersion( $versionID, $objectID );
        if ( !$contentVersion )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $contentVersion );
        }

        return $result;
    }

    function fetchContentNode( $nodeID, $nodePath, $languageCode, $remoteID = false )
    {
        $contentNode = null;
        if ( $nodeID )
        {
            if ( !isset( $languageCode ) )
                $languageCode = false;

            $contentNode = eZContentObjectTreeNode::fetch( $nodeID, $languageCode );
        }
        else if ( $nodePath )
        {
            $nodeID = eZURLAliasML::fetchNodeIDByPath( $nodePath );
            $contentNode = eZContentObjectTreeNode::fetch( $nodeID );
        }
        else if ( $remoteID )
        {
            $contentNode = eZContentObjectTreeNode::fetchByRemoteID( $remoteID );
        }
        if ( $contentNode === null )
        {
            $retVal = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $retVal = array( 'result' => $contentNode );
        }

        return $retVal;
    }

    function fetchNonTranslationList( $objectID, $version )
    {
        $version = eZContentObjectVersion::fetchVersion( $version, $objectID );
        if ( !$version )
            return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );

        $nonTranslationList = $version->nonTranslationList();
        if ( $nonTranslationList === null )
            return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );
        return array( 'result' => $nonTranslationList );
    }

    function fetchTranslationList()
    {
        $translationList = eZContentObject::translationList();
        if ( $translationList === null )
        {
            $result =  array( 'error' => array( 'error_type' => 'kernel',
                                                'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $translationList );
        }

        return $result;
    }

    function fetchPrioritizedLanguages()
    {
        $languages = eZContentLanguage::prioritizedLanguages();
        if ( $languages === null )
        {
            $result =  array( 'error' => array( 'error_type' => 'kernel',
                                                'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $languages );
        }

        return $result;
    }

    function fetchPrioritizedLanguageCodes()
    {
        $languageCodes = eZContentLanguage::prioritizedLanguageCodes();
        if ( $languageCodes === null )
        {
            $result =  array( 'error' => array( 'error_type' => 'kernel',
                                                'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $languageCodes );
        }

        return $result;
    }

    function fetchLocaleList( $withVariations )
    {
        $localeList = eZLocale::localeList( true, $withVariations );
        if ( $localeList === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $localeList );
        }

        return $result;
    }

    function fetchLocale( $localeCode )
    {
        // Fetch locale list
        $localeList = eZLocale::localeList( false, true );
        $localeObj = eZLocale::instance( $localeCode );
        // Check if $localeName exists
        if ( $localeObj === null or ( is_object( $localeObj ) and !in_array( $localeObj->localeFullCode(), $localeList ) ) )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $localeObj );
        }

        return $result;
    }

    function fetchObject( $objectID )
    {
        $object = eZContentObject::fetch( $objectID );
        if ( $object === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $object );
        }

        return $result;
    }

    function fetchClass( $classID )
    {
        if ( !is_numeric( $classID ) )
            $object = eZContentClass::fetchByIdentifier( $classID );
        else
            $object = eZContentClass::fetch( $classID );
        if ( $object === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $object );
        }

        return $result;
    }

    function fetchClassAttributeList( $classID, $versionID )
    {
        $objectList = eZContentClass::fetch( $classID )->fetchAttributes( false, true, $versionID );
        if ( $objectList === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $objectList );
        }

        return $result;
    }

    function fetchClassAttribute( $attributeID, $versionID )
    {
        $attribute = eZContentClassAttribute::fetch( $attributeID, true, $versionID );
        if ( $attribute === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $attribute );
        }

        return $result;
    }

    function calendar( $parentNodeID, $offset, $limit, $depth, $depthOperator,
                               $classID, $attribute_filter, $extended_attribute_filter, $class_filter_type, $class_filter_array,
                               $groupBy, $mainNodeOnly, $ignoreVisibility, $limitation )
    {
        $treeParameters = array( 'Offset' => $offset,
                                 'Limit' => $limit,
                                 'Limitation' => $limitation,
                                 'class_id' => $classID,
                                 'AttributeFilter' => $attribute_filter,
                                 'ExtendedAttributeFilter' => $extended_attribute_filter,
                                 'ClassFilterType' => $class_filter_type,
                                 'ClassFilterArray' => $class_filter_array,
                                 'IgnoreVisibility' => $ignoreVisibility,
                                 'MainNodeOnly' => $mainNodeOnly );
        if ( is_array( $groupBy ) )
        {
            $groupByHash = array( 'field' => $groupBy[0],
                                  'type' => false );
            if ( isset( $groupBy[1] ) )
                $groupByHash['type'] = $groupBy[1];
            $treeParameters['GroupBy'] = $groupByHash;
        }

        if ( $depth !== false )
        {
            $treeParameters['Depth'] = $depth;
            $treeParameters['DepthOperator'] = $depthOperator;
        }

        $children = null;
        if ( is_numeric( $parentNodeID ) )
        {
            $children = eZContentObjectTreeNode::calendar( $treeParameters,
                                                            $parentNodeID );
        }

        if ( $children === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $children );
        }
        return $result;
    }

    function fetchObjectTree( $parentNodeID, $sortBy, $onlyTranslated, $language, $offset, $limit, $depth, $depthOperator,
                              $classID, $attribute_filter, $extended_attribute_filter, $class_filter_type, $class_filter_array,
                              $groupBy, $mainNodeOnly, $ignoreVisibility, $limitation, $asObject, $objectNameFilter, $loadDataMap = null )
    {
        $treeParameters = array( 'Offset' => $offset,
                                 'OnlyTranslated' => $onlyTranslated,
                                 'Language' => $language,
                                 'Limit' => $limit,
                                 'Limitation' => $limitation,
                                 'SortBy' => $sortBy,
                                 'class_id' => $classID,
                                 'AttributeFilter' => $attribute_filter,
                                 'ExtendedAttributeFilter' => $extended_attribute_filter,
                                 'ClassFilterType' => $class_filter_type,
                                 'ClassFilterArray' => $class_filter_array,
                                 'IgnoreVisibility' => $ignoreVisibility,
                                 'ObjectNameFilter' => $objectNameFilter,
                                 'MainNodeOnly' => $mainNodeOnly );
        if ( is_array( $groupBy ) )
        {
            $groupByHash = array( 'field' => $groupBy[0],
                                  'type' => false );
            if ( isset( $groupBy[1] ) )
                $groupByHash['type'] = $groupBy[1];
            $treeParameters['GroupBy'] = $groupByHash;
        }
        if ( $asObject !== null )
            $treeParameters['AsObject'] = $asObject;
        if ( $loadDataMap )
            $treeParameters['LoadDataMap'] = true;
        else if ( $loadDataMap === null )
            $treeParameters['LoadDataMap'] = 15;
        if ( $depth !== false )
        {
            $treeParameters['Depth'] = $depth;
            $treeParameters['DepthOperator'] = $depthOperator;
        }

        $children = null;
        if ( is_numeric( $parentNodeID ) or is_array( $parentNodeID ) )
        {
            $children = eZContentObjectTreeNode::subTreeByNodeID( $treeParameters,
                                                                  $parentNodeID );
        }

        if ( $children === null )
        {
            return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            return array( 'result' => $children );
        }
    }

    function fetchObjectTreeCount( $parentNodeID, $onlyTranslated, $language, $class_filter_type, $class_filter_array,
                                   $attributeFilter, $depth, $depthOperator,
                                   $ignoreVisibility, $limitation, $mainNodeOnly, $extendedAttributeFilter, $objectNameFilter )
    {
        $childrenCount = null;

        if ( is_numeric( $parentNodeID ) or is_array( $parentNodeID ) )
        {
            $childrenCount = eZContentObjectTreeNode::subTreeCountByNodeID( array( 'Limitation' => $limitation,
                                                                           'ClassFilterType' => $class_filter_type,
                                                                           'ClassFilterArray' => $class_filter_array,
                                                                           'AttributeFilter' => $attributeFilter,
                                                                           'DepthOperator' => $depthOperator,
                                                                           'Depth' => $depth,
                                                                           'IgnoreVisibility' => $ignoreVisibility,
                                                                           'OnlyTranslated' => $onlyTranslated,
                                                                           'Language' => $language,
                                                                           'ObjectNameFilter' => $objectNameFilter,
                                                                           'ExtendedAttributeFilter' => $extendedAttributeFilter,
                                                                           'MainNodeOnly' => $mainNodeOnly ),
                                                                     $parentNodeID );
        }

        if ( $childrenCount === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                               'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $childrenCount );
        }
        return $result;
    }

    function fetchContentSearch( $searchText, $subTreeArray, $offset, $limit, $searchTimestamp, $publishDate, $sectionID,
                                 $classID, $classAttributeID, $ignoreVisibility, $limitation, $sortArray )
    {
        $searchArray = eZSearch::buildSearchArray();
        $parameters = array();
        if ( $classID !== false )
            $parameters['SearchContentClassID'] = $classID;
        if ( $classAttributeID !== false )
            $parameters['SearchContentClassAttributeID'] = $classAttributeID;
        if ( $sectionID !== false )
            $parameters['SearchSectionID'] = $sectionID;
        if ( $publishDate !== false )
            $parameters['SearchDate'] = $publishDate;
        if ( $sortArray !== false )
            $parameters['SortArray'] = $sortArray;
        $parameters['SearchLimit'] = $limit;
        $parameters['SearchOffset'] = $offset;
        $parameters['IgnoreVisibility'] = $ignoreVisibility;
        $parameters['Limitation'] = $limitation;

        if ( $subTreeArray !== false )
            $parameters['SearchSubTreeArray'] = $subTreeArray;
        if ( $searchTimestamp )
            $parameters['SearchTimestamp'] = $searchTimestamp;
        $searchResult = eZSearch::search( $searchText,
                                          $parameters,
                                          $searchArray );
        return array( 'result' => $searchResult );
    }

    function fetchTrashObjectCount( $objectNameFilter, $attributeFilter = false )
    {
        $params = array();
        if ( $objectNameFilter !== false )
        {
            $params['ObjectNameFilter'] = $objectNameFilter;
        }

        $params[ 'AttributeFilter' ] = $attributeFilter;

        $trashCount = eZContentObjectTrashNode::trashListCount( $params );
        return array( 'result' => $trashCount );
    }

    function fetchTrashObjectList( $offset, $limit, $objectNameFilter, $attributeFilter = false, $sortBy = false, $asObject = true )
    {
        $params = array();
        if ( $objectNameFilter !== false )
        {
            $params['ObjectNameFilter'] = $objectNameFilter;
        }
        $params[ 'Limit' ] = $limit;
        $params[ 'Offset' ] = $offset;
        $params[ 'AttributeFilter' ] = $attributeFilter;
        $params[ 'SortBy' ] = $sortBy;
        $params[ 'AsObject' ] = $asObject;

        $trashNodesList = eZContentObjectTrashNode::trashList( $params, false );
        return array( 'result' => $trashNodesList );
    }

    function fetchDraftVersionList( $offset, $limit )
    {
        $userID = eZUser::currentUserID();
        $draftVersionList =  eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                                   null, array(  'creator_id' => $userID,
                                                                                 'status' => eZContentObjectVersion::STATUS_DRAFT ),
                                                                   array( 'modified' => true,
                                                                          'initial_language_id' => true ),
                                                                   array( 'length' => $limit, 'offset' => $offset ),
                                                                   true );
        return array( 'result' => $draftVersionList );
    }

    function fetchDraftVersionCount()
    {
        $userID = eZUser::currentUserID();
        $draftVersionList = eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                                 array(),
                                                                 array( 'creator_id' => $userID,
                                                                        'status' => eZContentObjectVersion::STATUS_DRAFT ),
                                                                 false,
                                                                 null,
                                                                 false,
                                                                 false,
                                                                 array( array( 'operation' => 'count( * )',
                                                                               'name' => 'count' ) ) );
        return array( 'result' => $draftVersionList[0]['count'] );
    }

    function fetchPendingList( $offset, $limit )
    {
        $userID = eZUser::currentUserID();
        $pendingList =  eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                             null, array(  'creator_id' => $userID,
                                                                           'status' => eZContentObjectVersion::STATUS_PENDING ),
                                                             null, array( 'length' => $limit, 'offset' => $offset ),
                                                             true );
        return array( 'result' => $pendingList );

    }

    function fetchPendingCount()
    {
        $userID = eZUser::currentUserID();
        $pendingList = eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                            array(),
                                                            array( 'creator_id' => $userID,
                                                                   'status' => eZContentObjectVersion::STATUS_PENDING ),
                                                            false,
                                                            null,
                                                            false,
                                                            false,
                                                            array( array( 'operation' => 'count( * )',
                                                                          'name' => 'count' ) ) );
        return array( 'result' => $pendingList[0]['count'] );
    }


    function fetchVersionList( $contentObject, $offset, $limit, $sorts = null )
    {
        if ( !is_object( $contentObject ) )
            return array( 'result' => null );
        $versionList =  eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                              null, array(  'contentobject_id' => $contentObject->attribute("id") ),
                                                                   $sorts, array( 'length' => $limit, 'offset' => $offset ),
                                                                   true );
        return array( 'result' => $versionList );

    }

    function fetchVersionCount( $contentObject )
    {
        if ( !is_object( $contentObject ) )
            return array( 'result' => 0 );
        $versionList = eZPersistentObject::fetchObjectList( eZContentObjectVersion::definition(),
                                                            array(),
                                                            array( 'contentobject_id' => $contentObject->attribute( 'id' ) ),
                                                            false,
                                                            null,
                                                            false,
                                                            false,
                                                            array( array( 'operation' => 'count( * )',
                                                                          'name' => 'count' ) ) );
        return array( 'result' => $versionList[0]['count'] );
    }

    function canInstantiateClassList( $groupID, $parentNode, $filterType = 'include', $fetchID, $asObject )
    {
        $ClassGroupIDs = false;

        if ( is_numeric( $groupID ) && ( $groupID > 0 ) )
        {
            $ClassGroupIDs = array( $groupID );
        }
        else if( is_array( $groupID ) )
        {
            $ClassGroupIDs = $groupID;
        }

        if ( is_numeric( $parentNode ) )
            $parentNode = eZContentObjectTreeNode::fetch( $parentNode );

        if ( is_object( $parentNode ) )
        {
            $classList = $parentNode->canCreateClassList( $asObject, $filterType == 'include', $ClassGroupIDs, $fetchID );
        }
        else
        {
            $classList = eZContentClass::canInstantiateClassList( $asObject, $filterType == 'include', $ClassGroupIDs, $fetchID );
        }

        return array( 'result' => $classList );
    }

    function canInstantiateClasses( $parentNode )
    {
        if ( is_object( $parentNode ) )
        {
            $contentObject = $parentNode->attribute( 'object' );
            return array( 'result' => $contentObject->attribute( 'can_create' ) );
        }
        return array( 'result' => eZContentClass::canInstantiateClasses() );
    }

    function contentobjectAttributes( $version, $languageCode )
    {
        if ( $languageCode == '' )
        {
            return array( 'result' => $version->contentObjectAttributes( ) );
        }
        else
        {
            return array( 'result' => $version->contentObjectAttributes( $languageCode ) );
        }
    }

    function fetchBookmarks( $offset, $limit )
    {
        $user = eZUser::currentUser();
        return array( 'result' => eZContentBrowseBookmark::fetchListForUser( $user->id(), $offset, $limit ) );
    }

    function fetchRecent()
    {
        $user = eZUser::currentUser();
        return array( 'result' => eZContentBrowseRecent::fetchListForUser( $user->id() ) );
    }

    function fetchSectionList()
    {
        return array( 'result' => eZSection::fetchList() );
    }

    function fetchTipafriendTopList( $offset, $limit, $start_time, $end_time, $duration, $ascending, $extended )
    {
        $currentTime = time();
        $conds = array();

        if ( is_numeric( $start_time ) and is_numeric( $end_time ) )
        {
            $conds = array( 'requested' => array( false, array( $start_time, $end_time ) ) );
        }
        else if ( is_numeric( $start_time ) and is_numeric( $duration ) )
        {
            $conds = array( 'requested' => array( false, array( $start_time, $start_time + $duration ) ) );
        }
        else if ( is_numeric( $end_time ) and is_numeric( $duration ) )
        {
            $conds = array( 'requested' => array( false, array( $end_time - $duration, $end_time ) ) );
        }
        else if ( is_numeric( $start_time ) )
        {
            $conds = array( 'requested' => array( '>', $start_time ) );
        }
        else if ( is_numeric( $end_time ) )
        {
            $conds = array( 'requested' => array( '<', $end_time ) );
        }
        else if ( is_numeric( $duration ) )
        {
            // substract passed duration from current time timestamp to get start_time stamp
            // end_timestamp is equal to current time in this case
            $conds = array( 'requested' => array( '>', $currentTime - $duration ) );
        }

        $topList = eZPersistentObject::fetchObjectList( eZTipafriendCounter::definition(),
                                                        array( 'node_id' ),
                                                        $conds,
                                                        array( 'count' => ( $ascending ? 'asc' : 'desc' ) ),
                                                        array( 'length' => $limit, 'offset' => $offset ),
                                                        false,
                                                        array( 'node_id' ),
                                                        array( array( 'operation' => 'count( * )',
                                                                      'name' => 'count' ) ) );
        if ( $extended )
        {
            foreach ( array_keys( $topList ) as $key )
            {
                $contentNode = eZContentObjectTreeNode::fetch( $topList[ $key ][ 'node_id' ] );
                if ( !is_object( $contentNode ) )
                    return array( 'error' => array( 'error_type' => 'kernel',
                                                    'error_code' => eZError::KERNEL_NOT_FOUND ) );
                $topList[ $key ][ 'node' ] = $contentNode;
            }
            return array( 'result' => $topList );
        }
        else
        {
            $retList = array();
            foreach ( $topList as $entry )
            {
                $contentNode = eZContentObjectTreeNode::fetch( $entry[ 'node_id' ] );
                if ( !is_object( $contentNode ) )
                    return array( 'error' => array( 'error_type' => 'kernel',
                                                    'error_code' => eZError::KERNEL_NOT_FOUND ) );
                $retList[] = $contentNode;
            }
            return array( 'result' => $retList );
        }

    }

    function fetchMostViewedTopList( $classID, $sectionID, $offset, $limit )
    {
        $topList = eZViewCounter::fetchTopList( $classID, $sectionID, $offset, $limit );
        $contentNodeList = array();
        foreach ( array_keys ( $topList ) as $key )
        {
            $nodeID = $topList[$key]['node_id'];
            $contentNode = eZContentObjectTreeNode::fetch( $nodeID );
            if ( $contentNode === null )
                return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );
            $contentNodeList[] = $contentNode;
        }
        return array( 'result' => $contentNodeList );
    }

    function fetchCollectedInfoCount( $objectAttributeID, $objectID, $value, $creatorID = false, $userIdentifier = false )
    {
        return eZInfocollectorFunctionCollection::fetchCollectedInfoCount( $objectAttributeID, $objectID, $value, $creatorID, $userIdentifier );
    }

    function fetchCollectedInfoCountList( $objectAttributeID )
    {
        return eZInfocollectorFunctionCollection::fetchCollectedInfoCountList( $objectAttributeID );
    }

    function fetchCollectedInfoCollection( $collectionID, $contentObjectID )
    {
        return eZInfocollectorFunctionCollection::fetchCollectedInfoCollection( $collectionID, $contentObjectID );
    }

    function fetchCollectionsList( $objectID = false, $creatorID = false, $userIdentifier = false, $limit = false, $offset = false, $sortBy = false )
    {
        return eZInfocollectorFunctionCollection::fetchCollectionsList( $objectID,
                                                                        $creatorID,
                                                                        $userIdentifier,
                                                                        $limit,
                                                                        $offset,
                                                                        $sortBy );
     }

    function fetchObjectByAttribute( $identifier )
    {
        $contentObjectAttribute = eZContentObjectAttribute::fetchByIdentifier( $identifier );
        if ( $contentObjectAttribute === null )
        {
            $result = array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );
        }
        else
        {
            $result = array( 'result' => $contentObjectAttribute->attribute( 'object' ) );
        }
        return $result;
    }

    function fetchObjectCountByUserID( $classID, $userID )
    {
        $objectCount = eZContentObject::fetchObjectCountByUserID( $classID, $userID );
        return array( 'result' => $objectCount );
    }

    function fetchKeywordCount( $alphabet,
                                $classid,
                                $owner = false,
                                $parentNodeID = false,
                                $includeDuplicates = true,
                                $strictMatching = false )
    {
        $classIDArray = array();
        if ( is_numeric( $classid ) )
        {
            $classIDArray = array( $classid );
        }
        else if ( is_array( $classid ) )
        {
            $classIDArray = $classid;
        }

        $showInvisibleNodesCond = eZContentObjectTreeNode::createShowInvisibleSQLString( true, false );
        $limitation = false;
        $limitationList = eZContentObjectTreeNode::getLimitationList( $limitation );
        $sqlPermissionChecking = eZContentObjectTreeNode::createPermissionCheckingSQL( $limitationList );

        $db = eZDB::instance();

        $alphabet = $db->escapeString( $alphabet );

        $sqlOwnerString = is_numeric( $owner ) ? "AND ezcontentobject.owner_id = '$owner'" : '';
        $parentNodeIDString = is_numeric( $parentNodeID ) ? "AND ezcontentobject_tree.parent_node_id = '$parentNodeID'" : '';

        $sqlClassIDs = '';
        if ( $classIDArray != null )
        {
            $sqlClassIDs = 'AND ezkeyword.class_id IN (' . $db->implodeWithTypeCast( ',', $classIDArray, 'int' ) . ') ';
        }

        $sqlToExcludeDuplicates = '';
        if ( !$includeDuplicates )
        {
          //will use SELECT COUNT( DISTINCT ezcontentobject.id ) to count object only once even if it has
          //several keywords started with $alphabet.
          //COUNT( DISTINCT fieldName ) is SQL92 compliant syntax.
            $sqlToExcludeDuplicates = ' DISTINCT';
        }
        // composing sql for matching tag word, it could be strict equiality or LIKE clause dependent of $strictMatching parameter.
        $sqlMatching = "ezkeyword.keyword LIKE '$alphabet%'";
        if ( $strictMatching )
        {
            $sqlMatching = "ezkeyword.keyword = '$alphabet'";
        }

        $query = "SELECT COUNT($sqlToExcludeDuplicates ezcontentobject.id) AS count
                  FROM ezkeyword, ezkeyword_attribute_link,ezcontentobject_tree,ezcontentobject,ezcontentclass, ezcontentobject_attribute
                       $sqlPermissionChecking[from]
                  WHERE $sqlMatching
                  $showInvisibleNodesCond
                  $sqlPermissionChecking[where]
                  $sqlClassIDs
                  $sqlOwnerString
                  $parentNodeIDString
                  AND ezcontentclass.version=0
                  AND ezcontentobject.status=".eZContentObject::STATUS_PUBLISHED."
                  AND ezcontentobject_attribute.version=ezcontentobject.current_version
                  AND ezcontentobject_tree.main_node_id=ezcontentobject_tree.node_id
                  AND ezcontentobject_attribute.contentobject_id=ezcontentobject.id
                  AND ezcontentobject_tree.contentobject_id = ezcontentobject.id
                  AND ezcontentclass.id = ezcontentobject.contentclass_id
                  AND ezcontentobject_attribute.id=ezkeyword_attribute_link.objectattribute_id
                  AND ezkeyword_attribute_link.keyword_id = ezkeyword.id";

        $keyWords = $db->arrayQuery( $query );
        // cleanup temp tables
        $db->dropTempTableList( $sqlPermissionChecking['temp_tables'] );

        return array( 'result' => $keyWords[0]['count'] );
    }

    //
    //Returns an array( 'result' => array( 'keyword' => keyword, 'link_object' => node_id );
    //By default fetchKeyword gets a list of (not necessary unique) nodes and respective keyword strings
    //Search keyword provided in $alphabet parameter.
    //By default keyword matching implemented by LIKE so all keywords that starts with $alphabet
    //will successfully match. This means that if some object have attached keywords:
    //'Skien', 'Skien forests', 'Skien comunity' than fetchKeyword('Skien') will return tree entries
    //for this object.
    //Setting $includeDuplicates parameter to false makes fetchKeyword('Skien') to return just
    //one entry for such objects.
    function fetchKeyword( $alphabet,
                           $classid,
                           $offset,
                           $limit,
                           $owner = false,
                           $sortBy = array(),
                           $parentNodeID = false,
                           $includeDuplicates = true,
                           $strictMatching = false )
    {
        $classIDArray = array();
        if ( is_numeric( $classid ) )
        {
            $classIDArray = array( $classid );
        }
        else if ( is_array( $classid ) )
        {
            $classIDArray = $classid;
        }

        $showInvisibleNodesCond = eZContentObjectTreeNode::createShowInvisibleSQLString( true, false );
        $limitation = false;
        $limitationList = eZContentObjectTreeNode::getLimitationList( $limitation );
        $sqlPermissionChecking = eZContentObjectTreeNode::createPermissionCheckingSQL( $limitationList );

        $db_params = array();
        $db_params['offset'] = $offset;
        $db_params['limit'] = $limit;

        $keywordNodeArray = array();
        $lastKeyword = '';

        $db = eZDB::instance();

        //in SELECT clause below we will use a full keyword value
        //or just a part of ezkeyword.keyword matched to $alphabet respective to $includeDuplicates parameter.
        //In the case $includeDuplicates = ture we need only a part
        //of ezkeyword.keyword to be fetched in field to allow DISTINCT to remove rows with the same node id's
        $sqlKeyword = 'ezkeyword.keyword';
        if ( !$includeDuplicates )
        {
            $sqlKeyword = $db->subString('ezkeyword.keyword', 1, strlen( $alphabet ) ) . ' AS keyword ';
        }

        $alphabet = $db->escapeString( $alphabet );

        $sortingInfo = array();
        $sortingInfo['attributeFromSQL'] = ', ezcontentobject_attribute a1';
        $sortingInfo['attributeWhereSQL'] = '';
        $sqlTarget = $sqlKeyword.',ezcontentobject_tree.node_id';

        if ( is_array( $sortBy ) && count ( $sortBy ) > 0 )
        {
            switch ( $sortBy[0] )
            {
                case 'keyword':
                case 'name':
                {
                    $sortingString = '';
                    if ( $sortBy[0] == 'name' )
                        $sortingString = 'ezcontentobject.name';
                    elseif ( $sortBy[0] == 'keyword' )
                        $sortingString = 'ezkeyword.keyword';

                    $sortOrder = true; // true is ascending
                    if ( isset( $sortBy[1] ) )
                        $sortOrder = $sortBy[1];
                    $sortingOrder = $sortOrder ? ' ASC' : ' DESC';
                    $sortingInfo['sortingFields'] = $sortingString . $sortingOrder;
                } break;
                default:
                {
                    $sortingInfo = eZContentObjectTreeNode::createSortingSQLStrings( $sortBy );

                    if ( $sortBy[0] == 'attribute' )
                    {
                        // if sort_by is 'attribute' we should add ezcontentobject_name to "FromSQL" and link to ezcontentobject
                        $sortingInfo['attributeFromSQL']  .= ', ezcontentobject_name, ezcontentobject_attribute a1';
                        $sortingInfo['attributeWhereSQL'] .= ' ezcontentobject.id = ezcontentobject_name.contentobject_id AND';
                        $sqlTarget = 'DISTINCT ezcontentobject_tree.node_id, '.$sqlKeyword;
                    }
                    else // for unique declaration
                        $sortingInfo['attributeFromSQL']  .= ', ezcontentobject_attribute a1';

                } break;
            }
        }
        else
        {
            $sortingInfo['sortingFields'] = 'ezkeyword.keyword ASC';
        }
        $sortingInfo['attributeWhereSQL'] .= " a1.version=ezcontentobject.current_version
                                             AND a1.contentobject_id=ezcontentobject.id AND";

        //Adding DISTINCT to avoid duplicates,
        //check if DISTINCT keyword was added before providing clauses for sorting.
        if ( !$includeDuplicates && substr( $sqlTarget, 0, 9) != 'DISTINCT ' )
        {
            $sqlTarget = 'DISTINCT ' . $sqlTarget;
        }

        $sqlOwnerString = is_numeric( $owner ) ? "AND ezcontentobject.owner_id = '$owner'" : '';
        $parentNodeIDString = is_numeric( $parentNodeID ) ? "AND ezcontentobject_tree.parent_node_id = '$parentNodeID'" : '';

        $sqlClassIDString = '';
        if ( is_array( $classIDArray ) and count( $classIDArray ) )
        {
            $sqlClassIDString = 'AND ezkeyword.class_id IN (' . $db->implodeWithTypeCast( ',', $classIDArray, 'int' ) . ')';
        }

        // composing sql for matching tag word, it could be strict equiality or LIKE clause
        // dependent of $strictMatching parameter.
        $sqlMatching = "ezkeyword.keyword LIKE '$alphabet%'";
        if ( $strictMatching )
        {
            $sqlMatching = "ezkeyword.keyword = '$alphabet'";
        }

        $query = "SELECT $sqlTarget
                  FROM ezkeyword, ezkeyword_attribute_link,ezcontentobject_tree,ezcontentobject,ezcontentclass
                       $sortingInfo[attributeFromSQL]
                       $sqlPermissionChecking[from]
                  WHERE
                  $sortingInfo[attributeWhereSQL]
                  $sqlMatching
                  $showInvisibleNodesCond
                  $sqlPermissionChecking[where]
                  $sqlClassIDString
                  $sqlOwnerString
                  $parentNodeIDString
                  AND ezcontentclass.version=0
                  AND ezcontentobject.status=".eZContentObject::STATUS_PUBLISHED."
                  AND ezcontentobject_tree.main_node_id=ezcontentobject_tree.node_id
                  AND ezcontentobject_tree.contentobject_id = ezcontentobject.id
                  AND ezcontentclass.id = ezcontentobject.contentclass_id
                  AND a1.id=ezkeyword_attribute_link.objectattribute_id
                  AND ezkeyword_attribute_link.keyword_id = ezkeyword.id ORDER BY {$sortingInfo['sortingFields']}";

        $keyWords = $db->arrayQuery( $query, $db_params );

        $trans = eZCharTransform::instance();

        foreach ( $keyWords as $keywordArray )
        {
            $keyword = $keywordArray['keyword'];
            $nodeID = $keywordArray['node_id'];
            $nodeObject = eZContentObjectTreeNode::fetch( $nodeID );

            if ( $nodeObject != null )
            {
                $keywordLC = $trans->transformByGroup( $keyword, 'lowercase' );
                if ( $lastKeyword == $keywordLC )
                    $keywordNodeArray[] = array( 'keyword' => '', 'link_object' => $nodeObject );
                else
                    $keywordNodeArray[] = array( 'keyword' => $keyword, 'link_object' => $nodeObject );

                $lastKeyword = $keywordLC;
            }
            else
            {
                $lastKeyword = $trans->transformByGroup( $keyword, 'lowercase' );
            }
        }
        return array( 'result' => $keywordNodeArray );
    }

    function fetchSameClassAttributeNodeList( $contentclassattributeID, $value, $datatype )
    {
        if ( $datatype == "int" )
             $type = "data_int";
        else if ( $datatype == "float" )
             $type = "data_float";
        else if ( $datatype == "text" )
             $type = "data_text";
        else
        {
            eZDebug::writeError( "DatatypeString not supported in fetch same_classattribute_node, use int, float or text" );
            return false;
        }
        $db = eZDB::instance();
        $contentclassattributeID =(int) $contentclassattributeID;
        $value = $db->escapeString( $value );
        if ( $datatype != "text" )
            settype( $value, $datatype );
        $resultNodeArray = array();
        $nodeList = $db->arrayQuery( "SELECT ezcontentobject_tree.node_id, ezcontentobject.name, ezcontentobject_tree.parent_node_id
                                            FROM ezcontentobject_tree, ezcontentobject, ezcontentobject_attribute
                                           WHERE ezcontentobject_attribute.$type='$value'
                                             AND ezcontentobject_attribute.contentclassattribute_id='$contentclassattributeID'
                                             AND ezcontentobject_attribute.contentobject_id=ezcontentobject.id
                                             AND ezcontentobject_attribute.version=ezcontentobject.current_version
                                             AND ezcontentobject_tree.contentobject_version=ezcontentobject.current_version
                                             AND ezcontentobject_tree.contentobject_id=ezcontentobject.id
                                        ORDER BY ezcontentobject.name");

        foreach ( $nodeList as $nodeObject )
        {
            $nodeID = $nodeObject['node_id'];
            $node = eZContentObjectTreeNode::fetch( $nodeID );
            $resultNodeArray[] = $node;
        }
        return array( 'result' => $resultNodeArray );
    }

    function checkAccess( $access, $contentObject, $contentClassID, $parentContentClassID, $languageCode = false )
    {
        if ( $contentObject instanceof eZContentObjectTreeNode )
        {
            $contentObject = $contentObject->attribute( 'object' );
        }
        if (  $contentClassID !== false and !is_numeric( $contentClassID ) )
        {
            $class = eZContentClass::fetchByIdentifier( $contentClassID );
            if ( !$class )
                return array( 'error' => array( 'error_type' => 'kernel',
                                                'error_code' => eZError::KERNEL_NOT_FOUND ) );
            $contentClassID = $class->attribute( 'id' );
        }
        if ( $access and $contentObject instanceof eZContentObject )
        {
            $result = $contentObject->checkAccess( $access, $contentClassID, $parentContentClassID, false, $languageCode );
            return array( 'result' => $result );
        }
    }

    // Fetches all navigation parts as an array
    function fetchNavigationParts()
    {
        return array( 'result' => eZNavigationPart::fetchList() );
    }

    // Fetches one navigation parts by identifier
    function fetchNavigationPart( $identifier )
    {
        return array( 'result' => eZNavigationPart::fetchPartByIdentifier( $identifier ) );
    }

    function contentobjectRelationTypeMask( $contentObjectRelationTypes = false )
    {
        $relationTypeMask = 0;
        if ( is_array( $contentObjectRelationTypes ) )
        {
            $relationTypeMap = array( 'common'    => eZContentObject::RELATION_COMMON,
                                      'xml_embed' => eZContentObject::RELATION_EMBED,
                                      'xml_link'  => eZContentObject::RELATION_LINK,
                                      'attribute' => eZContentObject::RELATION_ATTRIBUTE );
            foreach ( $contentObjectRelationTypes as $relationType )
            {
                if ( isset( $relationTypeMap[$relationType] ) )
                {
                    $relationTypeMask |= $relationTypeMap[$relationType];
                }
                else
                {
                    eZDebug::writeWarning( "Unknown relation type: '$relationType'.", "eZContentFunctionCollection::contentobjectRelationTypeMask()" );
                }
            }
        }
        elseif ( !is_bool( $contentObjectRelationTypes ) )
        {
            $contentObjectRelationTypes = false;
        }

        if ( is_bool( $contentObjectRelationTypes ) )
        {
            $relationTypeMask = eZContentObject::relationTypeMask( $contentObjectRelationTypes );
        }

        return $relationTypeMask;
    }

    // Fetches related objects id grouped by relation types
    function fetchRelatedObjectsID( $objectID, $attributeID, $allRelations)
    {
        if ( !is_array( $allRelations ) || $allRelations === array() )
        {
            $allRelations = array( 'common', 'xml_embed', 'attribute' );
            if ( eZContentObject::isObjectRelationTyped() )
            {
                $allRelations[] = 'xml_link';
            }
        }

        $relatedObjectsTyped = array();
        foreach ( $allRelations as $relationType )
        {
            $relatedObjectsTyped[$relationType] =
                eZContentFunctionCollection::fetchRelatedObjects( $objectID, $attributeID, array( $relationType ), false, array() );
        }

        $relatedObjectsTypedIDArray = array();
        foreach ( $relatedObjectsTyped as $relationTypeName => $relatedObjectsByType )
        {
            $relatedObjectsTypedIDArray[$relationTypeName] = array();
            foreach ( $relatedObjectsByType['result'] as $relatedObjectByType )
            {
                $relatedObjectsTypedIDArray[$relationTypeName][] = $relatedObjectByType->ID;
            }
        }

        return array( 'result' => $relatedObjectsTypedIDArray );
    }

    // Fetches reverse related objects id grouped by relation types
    function fetchReverseRelatedObjectsID( $objectID, $attributeID, $allRelations )
    {
        if ( !is_array( $allRelations ) || $allRelations === array() )
        {
            $allRelations = array( 'common', 'xml_embed', 'attribute' );
            if ( eZContentObject::isObjectRelationTyped() )
            {
                $allRelations[] = 'xml_link';
            }
        }

        $relatedObjectsTyped = array();
        foreach ( $allRelations as $relationType )
        {
            $relatedObjectsTyped[$relationType] =
                eZContentFunctionCollection::fetchReverseRelatedObjects( $objectID, $attributeID, array( $relationType ), false, array(), null );
        }

        $relatedObjectsTypedIDArray = array();
        foreach ( $relatedObjectsTyped as $relationTypeName => $relatedObjectsByType )
        {
            $relatedObjectsTypedIDArray[$relationTypeName] = array();
            foreach ( $relatedObjectsByType['result'] as $relatedObjectByType )
            {
                $relatedObjectsTypedIDArray[$relationTypeName][] = $relatedObjectByType->ID;
            }
        }

        return array( 'result' =>$relatedObjectsTypedIDArray );
    }

    // Fetches reverse related objects
    function fetchRelatedObjects( $objectID, $attributeID, $allRelations, $groupByAttribute, $sortBy, $limit = false, $offset = false, $asObject = true, $loadDataMap = false, $ignoreVisibility = null )
    {
        if ( !$objectID )
        {
            eZDebug::writeError( "ObjectID is missing" );
            return false;
        }
        $params = array();
        $params['Limit'] = $limit;
        $params['Offset'] = $offset;
        $params['AsObject'] = $asObject;
        $params['LoadDataMap'] = $loadDataMap;

        if ( $sortBy )
        {
            if ( is_array( $sortBy ) )
            {
                $params['SortBy'] = $sortBy;
            }
            else
            {
                eZDebug::writeError( "Function parameter 'SortBy' should be an array.", 'content/fetchRelatedObjects' );
            }
        }

        if ( $ignoreVisibility !== null )
        {
            $params['IgnoreVisibility'] = $ignoreVisibility;
        }

        if ( !$attributeID )
        {
            $attributeID = 0;
        }

        if ( isset( $allRelations ) )
        {
            if ( $attributeID && !$allRelations )
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( array( 'attribute' ) );
            }
            elseif( $allRelations === true )
            {
                $attributeID = false;
            }
            else
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( $allRelations );
            }
        }

        if ( $attributeID && !is_numeric( $attributeID ) && !is_bool( $attributeID ) )
        {
            $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $attributeID );
            if ( !$attributeID )
            {
                eZDebug::writeError( "Can't get class attribute ID by identifier" );
                return false;
            }
        }

        $object = eZContentObject::fetch( $objectID );
        if ( $object === null )
            return false;
        return array( 'result' => $object->relatedContentObjectList( false, $objectID, $attributeID, $groupByAttribute, $params ) );
    }

        // Fetches count of reverse related objects
    function fetchRelatedObjectsCount( $objectID, $attributeID, $allRelations )
    {
        if ( !$objectID )
        {
            eZDebug::writeError( "ObjectID is missing" );
            return false;
        }

        $params=array();
        if ( !$attributeID )
        {
            $attributeID = 0;
        }

        if ( isset( $allRelations ) )
        {
            if ( $attributeID && !$allRelations )
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( array( 'attribute' ) );
            }
            elseif( $allRelations === true )
            {
                $attributeID = false;
            }
            else
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( $allRelations );
            }
        }

        if ( $attributeID && !is_numeric( $attributeID ) && !is_bool( $attributeID ) )
        {
            $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $attributeID );
            if ( !$attributeID )
            {
                eZDebug::writeError( "Can't get class attribute ID by identifier" );
                return false;
            }
        }

        $object = eZContentObject::fetch( $objectID );
        if ( $object === null )
            return false;
        return array( 'result' => $object->relatedContentObjectCount( false, $attributeID, $params ) );
    }

    function fetchReverseRelatedObjects( $objectID, $attributeID, $allRelations, $groupByAttribute, $sortBy, $ignoreVisibility,  $limit = false, $offset = false, $asObject = true, $loadDataMap = false  )
    {
        $params = array();
        $params['Limit'] = $limit;
        $params['Offset'] = $offset;
        $params['AsObject'] = $asObject;
        $params['LoadDataMap'] = $loadDataMap;

        if ( $sortBy )
        {
            if ( is_array( $sortBy ) )
            {
                $params['SortBy'] = $sortBy;
            }
            else
            {
                eZDebug::writeError( "Function parameter 'SortBy' should be an array.", 'content/fetchReverseRelatedObjects' );
            }
        }
        if ( isset( $ignoreVisibility ) )
        {
            $params['IgnoreVisibility'] = $ignoreVisibility;
        }
        if ( !$attributeID )
        {
            $attributeID = 0;
        }

        if ( isset( $allRelations ) )
        {
            if ( $attributeID && !$allRelations )
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( array( 'attribute' ) );
            }
            elseif( $allRelations === true )
            {
                $attributeID = false;
            }
            else
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( $allRelations );
            }
        }

        if ( $attributeID && !is_numeric( $attributeID ) && !is_bool( $attributeID ) )
        {
            $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $attributeID );
            if ( !$attributeID )
            {
                eZDebug::writeError( "Can't get class attribute ID by identifier" );
                return false;
            }
        }
        return array( 'result' => eZContentObject::fetch( $objectID )->reverseRelatedObjectList( false, $attributeID, $groupByAttribute, $params ) );
    }

    // Fetches count of reverse related objects
    function fetchReverseRelatedObjectsCount( $objectID, $attributeID, $allRelations, $ignoreVisibility  )
    {
        $params = array();
        if ( isset( $ignoreVisibility ) )
        {
            $params['IgnoreVisibility'] = $ignoreVisibility;
        }

        if ( !$attributeID )
        {
            $attributeID = 0;
        }

        if ( isset( $allRelations ) )
        {
            if ( $attributeID && !$allRelations )
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( array( 'attribute' ) );
            }
            elseif( $allRelations === true )
            {
                $attributeID = false;
            }
            else
            {
                $params['AllRelations'] = eZContentFunctionCollection::contentobjectRelationTypeMask( $allRelations );
            }
        }

        if ( $attributeID && !is_numeric( $attributeID ) && !is_bool( $attributeID ) )
        {
            $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $attributeID );
            if ( !$attributeID )
            {
                eZDebug::writeError( "Can't get class attribute ID by identifier" );
                return false;
            }
        }
        return array( 'result' => eZContentObject::fetch( $objectID )->reverseRelatedObjectCount( false, $attributeID, $params ) );
    }

    function fetchAvailableSortFieldList()
    {
        return array( 'result' => array( '6' => ezi18n( 'kernel/content', 'Class identifier' ),
                                         '7' => ezi18n( 'kernel/content', 'Class name' ),
                                         '5' => ezi18n( 'kernel/content', 'Depth' ),
                                         '3' => ezi18n( 'kernel/content', 'Modified' ),
                                         '9' => ezi18n( 'kernel/content', 'Name' ),
                                         '1' => ezi18n( 'kernel/content', 'Path String' ),
                                         '8' => ezi18n( 'kernel/content', 'Priority' ),
                                         '2' => ezi18n( 'kernel/content', 'Published' ),
                                         '4' => ezi18n( 'kernel/content', 'Section' ) ) );
    }

    function fetchCountryList( $filter, $value )
    {
        // Fetch country list
        if ( !$filter and !$value )
        {
            $country = eZCountryType::fetchCountryList();
        }
        else
        {
            $country = eZCountryType::fetchCountry( $value, $filter );
        }

        return array( 'result' => $country );
    }

    function fetchContentTreeMenuExpiry()
    {
        eZExpiryHandler::registerShutdownFunction();

        $expiryHandler = eZExpiryHandler::instance();

        if ( !$expiryHandler->hasTimestamp( 'content-tree-menu' ) )
        {
            $expiryHandler->setTimestamp( 'content-tree-menu', time() );
            $expiryHandler->store();
        }

        return array( 'result' => $expiryHandler->timestamp( 'content-tree-menu' ) );
    }
}

?>

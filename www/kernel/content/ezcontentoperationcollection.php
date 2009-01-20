<?php
//
// Definition of eZContentOperationCollection class
//
// Created on: <01-Nov-2002 13:51:17 amos>
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

/*! \file ezcontentoperationcollection.php
*/

/*!
  \class eZContentOperationCollection ezcontentoperationcollection.php
  \brief The class eZContentOperationCollection does

*/

require_once( 'kernel/classes/ezcontentlanguage.php' );

class eZContentOperationCollection
{
    /*!
     Constructor
    */
    function eZContentOperationCollection()
    {
    }

    function readNode( $nodeID )
    {

    }

    function readObject( $nodeID, $userID, $languageCode )
    {
        if ( $languageCode != '' )
        {
            $node = eZContentObjectTreeNode::fetch( $nodeID, $languageCode );
        }
        else
        {
            $node = eZContentObjectTreeNode::fetch( $nodeID );
        }

        if ( $node === null )
//            return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
            return false;


        $object = $node->attribute( 'object' );

        if ( $object === null )
//            return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
        {
            return false;
        }
/*
        if ( !$object->attribute( 'can_read' ) )
        {
//            return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
            return false;
        }
*/

        return array( 'status' => true, 'object' => $object, 'node' => $node );
    }

    function loopNodes( $nodeID )
    {
        return array( 'parameters' => array( array( 'parent_node_id' => 3 ),
                                             array( 'parent_node_id' => 5 ),
                                             array( 'parent_node_id' => 12 ) ) );
    }

    function loopNodeAssignment( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );

        $version = $object->version( $versionNum );
        $nodeAssignmentList = $version->attribute( 'node_assignments' );

        $parameters = array();
        foreach ( $nodeAssignmentList as $nodeAssignment )
        {
            if ( $nodeAssignment->attribute( 'parent_node' ) > 0 )
            {
                if ( $nodeAssignment->attribute( 'is_main' ) == 1 )
                {
                    $mainNodeID = $this->publishNode( $nodeAssignment->attribute( 'parent_node' ), $objectID, $versionNum, false );
                }
                else
                {
                    $parameters[] = array( 'parent_node_id' => $nodeAssignment->attribute( 'parent_node' ) );
                }
            }
        }
        for ( $i = 0; $i < count( $parameters ); $i++ )
        {
            $parameters[$i]['main_node_id'] = $mainNodeID;
        }

        return array( 'parameters' => $parameters );
    }

    function publishObjectExtensionHandler( $contentObjectID, $contentObjectVersion )
    {
        //include_once( 'kernel/classes/ezcontentobjectedithandler.php' );
        eZContentObjectEditHandler::executePublish( $contentObjectID, $contentObjectVersion );
    }

    function setVersionStatus( $objectID, $versionNum, $status )
    {
        $object = eZContentObject::fetch( $objectID );

        if ( !$versionNum )
        {
            $versionNum = $object->attribute( 'current_version' );
        }
        $version = $object->version( $versionNum );
        if ( !$version )
            return;
        switch ( $status )
        {
            case 1:
            {
                $statusName = 'pending';
                $version->setAttribute( 'status', eZContentObjectVersion::STATUS_PENDING );
            } break;
            case 2:
            {
                $statusName = 'archived';
                $version->setAttribute( 'status', eZContentObjectVersion::STATUS_ARCHIVED );
            } break;
            case 3:
            {
                $statusName = 'published';
                $version->setAttribute( 'status', eZContentObjectVersion::STATUS_PUBLISHED );
            } break;
            default:
                $statusName = 'none';
        }
        $version->store();
    }

    function setObjectStatusPublished( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $version = $object->version( $versionNum );

        $db = eZDB::instance();
        $db->begin();

        $object->publishContentObjectRelations( $versionNum );
        $object->setAttribute( 'status', eZContentObject::STATUS_PUBLISHED );
        $version->setAttribute( 'status', eZContentObjectVersion::STATUS_PUBLISHED );
        $object->setAttribute( 'current_version', $versionNum );

        $objectIsAlwaysAvailable = $object->isAlwaysAvailable();
        $object->setAttribute( 'language_mask', eZContentLanguage::maskByLocale( $version->translationList( false, false ), $objectIsAlwaysAvailable ) );

        if ( $object->attribute( 'published' ) == 0 )
        {
            $object->setAttribute( 'published', time() );
        }
        $object->setAttribute( 'modified', time() );

        $class = eZContentClass::fetch( $object->attribute( 'contentclass_id' ) );
        $objectName = $class->contentObjectName( $object );
        $object->setName( $objectName, $versionNum );
        $existingTranslations = $version->translations( false );
        foreach( $existingTranslations as $translation )
        {
            $translatedName = $class->contentObjectName( $object, $versionNum, $translation );
            $object->setName( $translatedName, $versionNum, $translation );
        }

        if ( $objectIsAlwaysAvailable )
        {
            $initialLanguageID = $object->attribute( 'initial_language_id' );
            $object->setAlwaysAvailableLanguageID( $initialLanguageID );
        }

        $version->store();
        $object->store();

        eZContentObjectTreeNode::setVersionByObjectID( $objectID, $versionNum );

        $nodes = $object->assignedNodes();
        foreach ( $nodes as $node )
        {
            $node->setName( $object->attribute( 'name' ) );
            $node->updateSubTreePath();
        }

        $db->commit();

        /* Check if current class is the user class, and if so, clean up the
         * user-policy cache */
        //include_once( "lib/ezutils/classes/ezini.php" );
        $ini = eZINI::instance();
        $userClassID = $ini->variable( "UserSettings", "UserClassID" );
        if ( $object->attribute( 'contentclass_id' ) == $userClassID )
        {
            //include_once( "kernel/classes/datatypes/ezuser/ezuser.php" );
            eZUser::cleanupCache();
        }
    }

    function attributePublishAction( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $nodes = $object->assignedNodes();
        $version = $object->version( $versionNum );
        $contentObjectAttributes = $object->contentObjectAttributes( true, $versionNum, $version->initialLanguageCode(), false );
        foreach ( $contentObjectAttributes as $contentObjectAttribute )
        {
            $contentObjectAttribute->onPublish( $object, $nodes );
        }
    }

    /*!
     \static
     Generates the related viewcaches (PreGeneration) for the content object.
     It will only do this if [ContentSettings]/PreViewCache in site.ini is enabled.

     \param $objectID The ID of the content object to generate caches for.
    */
    function generateObjectViewCache( $objectID )
    {
        //include_once( 'kernel/classes/ezcontentcachemanager.php' );
        eZContentCacheManager::generateObjectViewCache( $objectID );
    }

    /*!
     \static
     Clears the related viewcaches for the content object using the smart viewcache system.

     \param $objectID The ID of the content object to clear caches for
     \param $versionNum The version of the object to use or \c true for current version
     \param $additionalNodeList An array with node IDs to add to clear list,
                                or \c false for no additional nodes.
    */
    function clearObjectViewCache( $objectID, $versionNum = true, $additionalNodeList = false )
    {
        //include_once( 'kernel/classes/ezcontentcachemanager.php' );
        eZContentCacheManager::clearContentCacheIfNeeded( $objectID, $versionNum, $additionalNodeList );
    }


    /*!
    */
    function publishNode( $parentNodeID, $objectID, $versionNum, $mainNodeID )
    {
        $object         = eZContentObject::fetch( $objectID );
        $nodeAssignment = eZNodeAssignment::fetch( $objectID, $versionNum, $parentNodeID );
        $version = $object->version( $versionNum );

        $db = eZDB::instance();
        $db->begin();

        $fromNodeID       = $nodeAssignment->attribute( 'from_node_id' );
        $originalObjectID = $nodeAssignment->attribute( 'contentobject_id' );

        $nodeID           =  $nodeAssignment->attribute( 'parent_node' );
        $opCode           =  $nodeAssignment->attribute( 'op_code' );
        $parentNode       = eZContentObjectTreeNode::fetch( $nodeID );
        $parentNodeID     =  $parentNode->attribute( 'node_id' );
        $existingNode     =  null;

        if ( strlen( $nodeAssignment->attribute( 'parent_remote_id' ) ) > 0 )
        {
            $existingNode = eZContentObjectTreeNode::fetchByRemoteID( $nodeAssignment->attribute( 'parent_remote_id' ) );
        }
        if ( !$existingNode );
        {
            $existingNode = eZContentObjectTreeNode::findNode( $nodeID , $object->attribute( 'id' ), true );
        }
        $updateSectionID = false;
        // now we check the op_code to see what to do
        if ( ( $opCode & 1 ) == eZNodeAssignment::OP_CODE_NOP )
        {
            // There is nothing to do so just return
            $db->commit();
            if ( $mainNodeID == false )
            {
                return $existingNode->attribute( 'node_id' );
            }

            return;
        }

        $updateFields = false;

        if ( $opCode == eZNodeAssignment::OP_CODE_MOVE ||
             $opCode == eZNodeAssignment::OP_CODE_CREATE )
        {
//            if ( $fromNodeID == 0 || $fromNodeID == -1)
            if ( $opCode == eZNodeAssignment::OP_CODE_CREATE ||
                 $opCode == eZNodeAssignment::OP_CODE_SET )
            {
                // If the node already exists it means we have a conflict (for 'CREATE').
                // We resolve this by leaving node-assignment data be.
                if ( $existingNode == null )
                {
                    $parentNode = eZContentObjectTreeNode::fetch( $nodeID );

                    //include_once( 'kernel/classes/ezcontentbrowserecent.php' );
                    $user = eZUser::currentUser();
                    eZContentBrowseRecent::createNew( $user->id(), $parentNode->attribute( 'node_id' ), $parentNode->attribute( 'name' ) );
                    $updateFields = true;

                    $existingNode = $parentNode->addChild( $object->attribute( 'id' ), true );

                    if ( $fromNodeID == -1 )
                    {
                        $updateSectionID = true;
                    }
                }
                elseif ( $opCode == eZNodeAssignment::OP_CODE_SET )
                {
                    $updateFields = true;
                }
            }
            elseif ( $opCode == eZNodeAssignment::OP_CODE_MOVE )
            {
                if ( $fromNodeID == 0 || $fromNodeID == -1 )
                {
                    eZDebug::writeError( "NodeAssignment '", $nodeAssignment->attribute( 'id' ), "' is marked with op_code='$opCode' but has no data in from_node_id. Cannot use it for moving node." );
                }
                else
                {
                    // clear cache for old placement.
                    $additionalNodeIDList = array( $fromNodeID );

                    //include_once( 'kernel/classes/ezcontentcachemanager.php' );
                    eZContentCacheManager::clearContentCacheIfNeeded( $objectID, $versionNum, $additionalNodeIDList );

                    $originalNode = eZContentObjectTreeNode::fetchNode( $originalObjectID, $fromNodeID );
                    if ( $originalNode->attribute( 'main_node_id' ) == $originalNode->attribute( 'node_id' ) )
                    {
                        $updateSectionID = true;
                    }
                    $originalNode->move( $parentNodeID );
                    $existingNode = eZContentObjectTreeNode::fetchNode( $originalObjectID, $parentNodeID );
                    $updateFields = true;
                }
            }
        }
        elseif ( $opCode == eZNodeAssignment::OP_CODE_REMOVE )
        {
            $db->commit();
            return;
        }

        if ( $updateFields )
        {
            if ( strlen( $nodeAssignment->attribute( 'parent_remote_id' ) ) > 0 )
            {
                $existingNode->setAttribute( 'remote_id', $nodeAssignment->attribute( 'parent_remote_id' ) );
            }
            $existingNode->setAttribute( 'sort_field', $nodeAssignment->attribute( 'sort_field' ) );
            $existingNode->setAttribute( 'sort_order', $nodeAssignment->attribute( 'sort_order' ) );
        }
        $existingNode->setAttribute( 'contentobject_is_published', 1 );

        eZDebug::createAccumulatorGroup( 'nice_urls_total', 'Nice urls' );

        if ( $mainNodeID > 0 )
        {
            $existingNodeID = $existingNode->attribute( 'node_id' );
            if ( $existingNodeID != $mainNodeID )
            {
                //include_once( 'kernel/classes/ezcontentbrowserecent.php' );
                eZContentBrowseRecent::updateNodeID( $existingNodeID, $mainNodeID );
            }
            $existingNode->setAttribute( 'main_node_id', $mainNodeID );
        }
        else
        {
            $existingNode->setAttribute( 'main_node_id', $existingNode->attribute( 'node_id' ) );
        }

        $existingNode->store();

        if ( $updateSectionID )
        {
            eZContentOperationCollection::updateSectionID( $objectID, $versionNum );
        }
        $db->commit();
        if ( $mainNodeID == false )
        {
            return $existingNode->attribute( 'node_id' );
        }
    }

    function updateSectionID( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );

        $version = $object->version( $versionNum );

        if ( $versionNum == 1 or
             $object->attribute( 'current_version' ) == $versionNum )
        {
            $newMainAssignment = null;
            $newMainAssignments = eZNodeAssignment::fetchForObject( $objectID, $versionNum, 1 );
            if ( isset( $newMainAssignments[0] ) )
            {
                $newMainAssignment = $newMainAssignments[0];
            }
            // we should not update section id for toplevel nodes
            if ( $newMainAssignment && $newMainAssignment->attribute( 'parent_node' ) != 1 )
            {
                // We should check if current object already has been updated for section_id
                // If yes we should not update object section_id by $parentNodeSectionID
                $sectionID = $object->attribute( 'section_id' );
                if ( $sectionID > 0 )
                    return;

                $newParentObject = $newMainAssignment->getParentObject();
                if ( !$newParentObject )
                {
                    return array( 'status' => eZModuleOperationInfo::STATUS_CANCELLED );
                }
                $parentNodeSectionID = $newParentObject->attribute( 'section_id' );
                $object->setAttribute( 'section_id', $parentNodeSectionID );
                $object->store();
            }

            return;
        }

        $newMainAssignmentList = eZNodeAssignment::fetchForObject( $objectID, $versionNum, 1 );
        $newMainAssignment = ( count( $newMainAssignmentList ) ) ? array_pop( $newMainAssignmentList ) : null;

        $currentVersion = $object->attribute( 'current' );
        // Here we need to fetch published nodes and not old node assignments.
        $oldMainNode = $object->mainNode();

        if ( $newMainAssignment && $oldMainNode
             &&  $newMainAssignment->attribute( 'parent_node' ) != $oldMainNode->attribute( 'parent_node_id' ) )
        {
            $oldMainParentNode = $oldMainNode->attribute( 'parent' );
            if ( $oldMainParentNode )
            {
                $oldParentObject = $oldMainParentNode->attribute( 'object' );
                $oldParentObjectSectionID = $oldParentObject->attribute( 'section_id' );
                if ( $oldParentObjectSectionID == $object->attribute( 'section_id' ) )
                {
                    $newParentNode = $newMainAssignment->attribute( 'parent_node_obj' );
                    if ( !$newParentNode )
                        return;
                    $newParentObject = $newParentNode->attribute( 'object' );
                    if ( !$newParentObject )
                        return;

                    $newSectionID = $newParentObject->attribute( 'section_id' );

                    if ( $newSectionID != $object->attribute( 'section_id' ) )
                    {
                        $oldSectionID = $object->attribute( 'section_id' );
                        $object->setAttribute( 'section_id', $newSectionID );

                        $db = eZDB::instance();
                        $db->begin();
                        $object->store();
                        $mainNodeID = $object->attribute( 'main_node_id' );
                        if ( $mainNodeID > 0 )
                        {
                            eZContentObjectTreeNode::assignSectionToSubTree( $mainNodeID,
                                                                             $newSectionID,
                                                                             $oldSectionID );
                        }
                        $db->commit();
                    }
                }
            }
        }
    }

    function removeOldNodes( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );


        $version = $object->version( $versionNum );
        $moveToTrash = true;

        $assignedExistingNodes = $object->attribute( 'assigned_nodes' );

        $curentVersionNodeAssignments = $version->attribute( 'node_assignments' );
        $removeParentNodeList = array();
        $removeAssignmentsList = array();
        foreach ( $curentVersionNodeAssignments as $nodeAssignment )
        {
            $nodeAssignmentOpcode = $nodeAssignment->attribute( 'op_code' );
            if ( $nodeAssignmentOpcode == eZNodeAssignment::OP_CODE_REMOVE ||
                 $nodeAssignmentOpcode == eZNodeAssignment::OP_CODE_REMOVE_NOP )
            {
                $removeAssignmentsList[] = $nodeAssignment->attribute( 'id' );
                if ( $nodeAssignmentOpcode == eZNodeAssignment::OP_CODE_REMOVE )
                {
                    $removeParentNodeList[] = $nodeAssignment->attribute( 'parent_node' );
                }
            }
        }

        $db = eZDB::instance();
        $db->begin();
        foreach ( $assignedExistingNodes as $node )
        {
            if ( in_array( $node->attribute( 'parent_node_id' ), $removeParentNodeList ) )
            {
                eZContentObjectTreeNode::removeSubtrees( array( $node->attribute( 'node_id' ) ), $moveToTrash );
            }
        }

        if ( count( $removeAssignmentsList ) > 0 )
        {
            eZNodeAssignment::purgeByID( $removeAssignmentsList );
        }

        $db->commit();
    }

    // New function which resets the op_code field when the object is published.
    function resetNodeassignmentOpcodes( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $version = $object->version( $versionNum );
        $nodeAssignments = $version->attribute( 'node_assignments' );
        foreach ( $nodeAssignments as $nodeAssignment )
        {
            if ( ( $nodeAssignment->attribute( 'op_code' ) & 1 ) == eZNodeAssignment::OP_CODE_EXECUTE )
            {
                $nodeAssignment->setAttribute( 'op_code', ( $nodeAssignment->attribute( 'op_code' ) & ~1 ) );
                $nodeAssignment->store();
            }
        }
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    static function registerSearchObject( $objectID, $versionNum )
    {
        eZDebug::createAccumulatorGroup( 'search_total', 'Search Total' );

        //include_once( "lib/ezutils/classes/ezini.php" );

        $ini = eZINI::instance( 'site.ini' );
        $delayedIndexing = ( $ini->variable( 'SearchSettings', 'DelayedIndexing' ) == 'enabled' );

        if ( $delayedIndexing )
        {
            //include_once( "lib/ezdb/classes/ezdb.php" );

            $db = eZDB::instance();
            $db->query( 'INSERT INTO ezpending_actions( action, param ) VALUES ( \'index_object\', '. (int)$objectID. ' )' );
        }
        else
        {
            //include_once( "kernel/classes/ezsearch.php" );
            $object = eZContentObject::fetch( $objectID );
            // Register the object in the search engine.
            eZDebug::accumulatorStart( 'remove_object', 'search_total', 'remove object' );
            eZSearch::removeObject( $object );
            eZDebug::accumulatorStop( 'remove_object' );
            eZDebug::accumulatorStart( 'add_object', 'search_total', 'add object' );
            eZSearch::addObject( $object );
            eZDebug::accumulatorStop( 'add_object' );
        }
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    function createNotificationEvent( $objectID, $versionNum )
    {
        //include_once( 'kernel/classes/notification/eznotificationevent.php' );
        $event = eZNotificationEvent::create( 'ezpublish', array( 'object' => $objectID,
                                                                   'version' => $versionNum ) );
        $event->store();
    }

    /*!
      Start global transaction.
     */
    function beginPublish()
    {
        $db = eZDB::instance();
        $db->begin();
    }

    /*!
     Stop (commit) global transaction.
     */
    function endPublish()
    {
        $db = eZDB::instance();
        $db->commit();
    }

    /*!
     Copies missing translations from published version to the draft.
     */
    function copyTranslations( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $publishedVersionNum = $object->attribute( 'current_version' );
        if ( !$publishedVersionNum )
        {
            return;
        }
        $publishedVersion = $object->version( $publishedVersionNum );
        $publishedVersionTranslations = $publishedVersion->translations();
        $publishedLanguages = eZContentLanguage::languagesByMask( $object->attribute( 'language_mask' ) );
        $publishedLanguageCodes = array_keys( $publishedLanguages );

        $version = $object->version( $versionNum );
        $versionTranslationList = $version->translationList( false, false );

        foreach ( $publishedVersionTranslations as $translation )
        {
            if ( in_array( $translation->attribute( 'language_code' ), $versionTranslationList )
              || !in_array( $translation->attribute( 'language_code' ), $publishedLanguageCodes ) )
            {
                continue;
            }

            $contentObjectAttributes = $translation->objectAttributes();
            foreach ( $contentObjectAttributes as $attribute )
            {
                $clonedAttribute = $attribute->cloneContentObjectAttribute( $versionNum, $publishedVersionNum, $objectID );
                $clonedAttribute->sync();
            }
        }

        $version->updateLanguageMask();
    }

    /*!
     Updates non-translatable attributes.
     */
    function updateNontranslatableAttributes( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $version = $object->version( $versionNum );

        $nonTranslatableAttributes = $version->nonTranslatableAttributesToUpdate();
        if ( $nonTranslatableAttributes )
        {
            $attributes = $version->contentObjectAttributes( $version->initialLanguageCode() );
            $attributeByClassAttrID = array();
            foreach ( $attributes as $attribute )
            {
                $attributeByClassAttrID[$attribute->attribute( 'contentclassattribute_id' )] = $attribute;
            }

            foreach ( $nonTranslatableAttributes as $attributeToUpdate )
            {
                $originalAttribute =& $attributeByClassAttrID[$attributeToUpdate->attribute( 'contentclassattribute_id' )];
                if ( $originalAttribute )
                {
                    unset( $tmp );
                    $tmp = $attributeToUpdate;
                    $tmp->initialize( $attributeToUpdate->attribute( 'version' ), $originalAttribute );
                    $tmp->setAttribute( 'id', $attributeToUpdate->attribute( 'id' ) );
                    $tmp->setAttribute( 'language_code', $attributeToUpdate->attribute( 'language_code' ) );
                    $tmp->setAttribute( 'language_id', $attributeToUpdate->attribute( 'language_id' ) );
                    $tmp->setAttribute( 'attribute_original_id', $originalAttribute->attribute( 'id' ) );
                    $tmp->store();
                    $tmp->postInitialize( $attributeToUpdate->attribute( 'version' ), $originalAttribute );
                }
            }
        }
    }

    function removeTemporaryDrafts( $objectID, $versionNum )
    {
        $object = eZContentObject::fetch( $objectID );
        $object->cleanupInternalDrafts( eZUser::currentUserID() );
    }
}

?>

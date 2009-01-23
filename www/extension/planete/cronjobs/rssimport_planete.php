<?php

$planetINI = eZINI::instance( 'planete.ini' );
$planetRootNodeID = $planetINI->variable( 'TreeSettings', 'PlanetRootNodeID' );
$siteClassID = $planetINI->variable( 'ImportSettings', 'SiteClassID' );
$postClassID = $planetINI->variable( 'ImportSettings', 'PostClassID' );
$postOwnerID = $planetINI->variable( 'ImportSettings', 'PostOwnerID' );

$titleAttributeID = $planetINI->variable( 'ImportSettings', 'PostTitleAttributeID' );
$descriptionAttributeID = $planetINI->variable( 'ImportSettings', 'PostDescriptionAttributeID' );
$urlAttributeID = $planetINI->variable( 'ImportSettings', 'PostURLAttributeID' );

$params = array( 'ClassFilterType' => 'include',
                 'ClassFilterArray' => array( $siteClassID ) );

$blogNodes = eZContentObjectTreeNode::subTreeByNodeID( $params, $planetRootNodeID );
$blogPostContentClass = eZContentClass::fetch( $postClassID );

$db = eZDB::instance();

eZLog::setMaxLogSize( $planetINI->variable( 'ImportSettings', 'MaxLogSize' ) );
$logFile = $planetINI->variable( 'ImportSettings', 'LogFile' );

$updated = false;
foreach ( $blogNodes as $blog )
{
    eZLog::write( $blog->attribute( 'name' ), $logFile );
    $dataMap = $blog->attribute( 'data_map' );
    $rssSource = $dataMap['rss']->attribute( 'content' );
    try
    {
        $feed = ezcFeed::parse( $rssSource );
    }
    catch( Exception $e )
    {
        eZLog::write( 'Planet RSSImport ' . $rssSource
                      . ' failed to import document', $logFile );
        continue ;
    }
    if ( !is_array( $feed->item ) )
    {
        continue;
    }

    $blogContentObject = $blog->attribute( 'object' );
    foreach( $feed->item as $item )
    {
        eZLog::write( $item->title, $logFile );
        if ( isset( $item->id ) )
        {
            $md5Sum = md5( $item->id );
        }
        else
        {
            $md5Sum = md5( $item->link[0] );
        }
        $remoteID = $md5Sum . '_' . $blog->attribute( 'node_id' ) . '_Planete_RSSImport';
        $contentObject = eZContentObject::fetchByRemoteID( $remoteID );
        $dataMap = null;
        $db->begin();
        if ( !is_object( $contentObject ) )
        {
            eZLog::write( '-> Creating new content object', $logFile );
            $contentObject = $blogPostContentClass->instantiate( $postOwnerID, $blogContentObject->attribute( 'section_id' ) );
            $contentObject->store();
            $contentObjectID = $contentObject->attribute( 'id' );

            // Create node assignment
            $nodeAssignment = eZNodeAssignment::create( array( 'contentobject_id' => $contentObjectID,
                                                               'contentobject_version' => $contentObject->attribute( 'current_version' ),
                                                               'is_main' => 1,
                                                               'parent_node' => $blog->attribute( 'node_id' ) ) );
            $nodeAssignment->store();

            $version = $contentObject->version( 1 );
            $version->setAttribute( 'status', eZContentObjectVersion::STATUS_DRAFT );
            $version->store();
            $dataMap = $version->attribute( 'data_map' );
        }
        else
        {
            // need to check if the object required an update
            $dataMapObject = $contentObject->attribute( 'data_map' );
            foreach( $dataMapObject as $k => $contentAttribute )
            {
                $data = $dataMapObject[$k]->attribute( 'content' );
                if ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $titleAttributeID )
                {
                    if ( $data != trim( $item->title ) )
                    {
                        $version = $contentObject->createNewVersion();
                        $dataMap = $version->attribute( 'data_map' );
                        break;
                    }
                }
                elseif ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $descriptionAttributeID )
                {
                    if ( $data != trim( $item->description ) )
                    {
                        $version = $contentObject->createNewVersion();
                        $dataMap = $version->attribute( 'data_map' );
                        break;
                    }
                }
                elseif ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $urlAttributeID )
                {
                    if ( $data != trim( $item->link[0] ) )
                    {
                        $version = $contentObject->createNewVersion();
                        $dataMap = $version->attribute( 'data_map' );
                        break;
                    }
                }
            }

        }
        if ( $dataMap !== null )
        {
            eZLog::write( '-> ' . $contentObject->attribute( 'name' )
                                . ' need update', $logFile );
            foreach( $dataMap as $k => $contentAttribute )
            {
                if ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $titleAttributeID )
                {
                    $dataMap[$k]->fromString( trim( $item->title ) );
                    $dataMap[$k]->store();
                }
                elseif ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $descriptionAttributeID )
                {
                    $dataMap[$k]->fromString( trim( $item->description ) );
                    $dataMap[$k]->store();
                }
                elseif ( $contentAttribute->attribute( 'contentclassattribute_id' ) == $urlAttributeID )
                {
                    $dataMap[$k]->fromString( trim( $item->link[0] ) );
                    $dataMap[$k]->store();
                }
            }
            $contentObject->setAttribute( 'remote_id', $remoteID );
            $contentObject->store();
            $updated = true;
            $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObject->attribute( 'id' ),
                                                                                         'version' => $version->attribute( 'version' ) ) );
            if ( isset( $item->published ) )
            {
                $ts = $item->published->date->format( 'U' );
                $contentObject->setAttribute( 'published', $ts );
                $contentObject->setAttribute( 'modified', $ts );
                $contentObject->store();
                $version = $contentObject->attribute( 'current' );
                $version->setAttribute( 'created', $ts );
                $version->store();
            }
        }
        else
        {
            eZLog::write( ' -> nothing to do', $logFile );
        }
        $db->commit();
    }
}
if ( $updated )
{
    $ini = eZINI::instance();
    // need to clear feed/planet cache
    eZLog::write( 'Need to clear feed/planet cache', $logFile );
    $cacheInfo = eZPlaneteUtils::rssCacheInfo();
    eZFSFileHandler::fileDelete( $cacheInfo['cache-dir'] . '/' . $cacheInfo['cache-file'] );
    // make sure we always serve a cached file
    file_get_contents( 'http://' . $ini->variable( 'SiteSettings', 'SiteURL' ) . '/feed/planet' );
}

eZStaticCache::executeActions();

?>

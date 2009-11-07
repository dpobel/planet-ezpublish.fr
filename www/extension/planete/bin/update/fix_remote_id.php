#!/usr/bin/env php
<?php
/**
 * $Id$
 * $HeadURL$
 */
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "Update remote id content object created by rssimport_planete.php" ),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();
$script->initialize();

$planetINI = eZINI::instance( 'planete.ini' );
$rootNodeID = $planetINI->variable( 'TreeSettings', 'PlanetRootNodeID' );

$params = array( 'ClassFilterType' => 'include',
                 'ClassFilterArray' => array( 'post' ),
                 'Limit' => 1000,
                 'Offset' => 0 );
while ( true )
{
    $list = eZContentObjectTreeNode::subTreeByNodeID( $params, $rootNodeID );
    if ( !is_array( $list ) || empty( $list ) )
    {
        break;
    }
    foreach( $list as $node )
    {
        $cli->output( 'Updating remote id of ' . $node->attribute( 'name' ) );
        $parentNodeID = $node->attribute( 'parent_node_id' );
        $object = $node->attribute( 'object' );
        $oldRemoteID = $object->attribute( 'remote_id' );
        list( $md5Sum, $planete, $rssImport ) = explode( '_', $oldRemoteID );
        $remoteID = $md5Sum . '_' . $parentNodeID . '_Planete_RSSImport';
        $object->setAttribute( 'remote_id', $remoteID );
        $object->store();
    }
    $params['Offset'] += $params['Limit'];
    eZContentObject::clearCache();
}

$script->shutdown();
?>

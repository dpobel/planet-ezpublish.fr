#!/usr/bin/env php
<?php
/**
 * $Id$
 * $HeadURL$
 */
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "Update modified_subnode field of site object" ),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();
$script->initialize();

$planetINI = eZINI::instance( 'planete.ini' );
$rootNodeID = $planetINI->variable( 'TreeSettings', 'PlanetRootNodeID' );

$params = array( 'ClassFilterType' => 'include',
                 'ClassFilterArray' => array( 'site' ),
                 'Limit' => 100,
                 'Offset' => 0 );
$paramsPost = array( 'ClassFilterType' => 'include',
                     'ClassFilterArray' => array( 'post' ),
                     'SortBy' => array( array( 'modified', false ) ),
                     'Limit' => 1,
                     'Offset' => 0 );
$db = eZDB::instance();

while ( true )
{
    $list = eZContentObjectTreeNode::subTreeByNodeID( $params, $rootNodeID );
    if ( !is_array( $list ) || empty( $list ) )
    {
        break;
    }
    foreach( $list as $node )
    {
        $firstPostArray = eZContentObjectTreeNode::subTreeByNodeID( $paramsPost, $node->attribute( 'node_id' ) );
        if ( is_array( $firstPostArray ) && !empty( $firstPostArray ) )
        {
            $object = $firstPostArray[0]->attribute( 'object' );
            $modified = $object->attribute( 'modified' );
            $cli->output( 'Updating modifed_subnode of '
                           . $node->attribute( 'name' )
                           . ' from '
                           . $firstPostArray[0]->attribute( 'name' )
                           . ' (' . $modified . ')' );
            // $node->setAttribute( 'modified_subnode', $modified );
            // $node->store();
            // can't use eZContentObjectTreeNode::store(), as it reset modified_subnode to current timestamp
            $nodesID = explode( '/', $node->attribute( 'path_string' ) );
            unset( $nodesID[0] );
            unset( $nodesID[count( $nodesID )] );
            $query = 'UPDATE ezcontentobject_tree SET modified_subnode=' . $modified
                     . ' WHERE node_id IN (' . join( ',', $nodesID ) . ')';
            $cli->output( $query );
            $db->query( $query );
        }
    }
    $params['Offset'] += $params['Limit'];
    eZContentObject::clearCache();
}

$script->shutdown();
?>

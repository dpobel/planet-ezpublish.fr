#!/usr/bin/env php
<?php
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
                     'SortBy' => array( array( 'attribute', false, 'post/date' ) ),
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
            $version = $node->object()->createNewVersion();
            $dataMapPost = $firstPostArray[0]->dataMap();
            $dataMap = $version->dataMap();
            $cli->output( "New modification date of {$node->attribute( 'name' )}: {$dataMapPost['date']->toString()}" );
            foreach ( $dataMap as $k => $val )
            {
                if ( $k === 'modification_date' )
                {
                    $dataMap[$k]->fromString(
                        $dataMapPost['date']->toString()
                    );
                }
                $dataMap[$k]->store();
            }
            eZOperationHandler::execute(
                'content', 'publish',
                array(
                    'object_id' => $node->attribute( 'object' )->attribute( 'id' ),
                    'version' => $version->attribute( 'version' )
                )
            );


        }
    }
    $params['Offset'] += $params['Limit'];
    eZContentObject::clearCache();
}

$script->shutdown();
?>

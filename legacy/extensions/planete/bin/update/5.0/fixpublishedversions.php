#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(
    array(
        'description' => "Make sure only one version is in state 'published' at a time",
        'use-session' => false,
        'use-modules' => true,
        'use-extensions' => true
    )
);

$script->startup();
$script->initialize();

$planetINI = eZINI::instance( 'planete.ini' );
$rootNodeID = $planetINI->variable( 'TreeSettings', 'PlanetRootNodeID' );

$params = array(
    'Limit' => 100,
    'Offset' => 0,
    'Limitation' => array(),
    'IgnoreVisibility' => true,
);
$db = eZDB::instance();

while ( true )
{
    $nodes = eZContentObjectTreeNode::subTreeByNodeID( $params, $rootNodeID );
    if ( empty( $nodes ) )
    {
        break;
    }
    foreach ( $nodes as $node )
    {
        $object = $node->attribute( 'object' );
        $cli->output( ' - ' . $node->attribute( 'name' ), false );
        $versions = $object->versions(
            true,
            array(
                'conditions' => array(
                    'status' => eZContentObjectVersion::STATUS_PUBLISHED
                ),
                'sort' => array( 'modified' => 'desc' )
            )
        );
        $count = count( $versions );
        if ( $count <= 1 )
        {
            $cli->output( ' OK' );
        }
        else
        {
            $cli->output( " KO" );
            $cli->output( "    o Found $count published versions, fixing this mess..." );
            array_shift( $versions );
            $db->begin();
            foreach ( $versions as $version )
            {
                $version->setAttribute(
                    'status', eZContentObjectVersion::STATUS_ARCHIVED
                );
                $version->store();
            }
            $cli->output( '    o OK now :-)' );
            $db->commit();
        }
    }
    $params['Offset'] += $params['Limit'];
}


$script->shutdown();

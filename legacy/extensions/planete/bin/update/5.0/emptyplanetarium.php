#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(
    array(
        'description' => "Empty the planetarium",
        'use-session' => false,
        'use-modules' => true,
        'use-extensions' => true,
    )
);

$script->startup();
$script->initialize();

$limit = 50;
$offset = 0;
$identifier = 'post';

$userCreatorID = eZINI::instance( 'planete.ini' )
    ->variable( 'ImportSettings', 'PostOwnerID' );
$user = eZUser::fetch( $userCreatorID );
eZUser::setCurrentlyLoggedInUser( $user, $userCreatorID );


while ( true )
{
    $posts = eZContentObjectTreeNode::subTreeByNodeID(
        array(
            'ClassFilterType' => 'include',
            'ClassFilterArray' => array( $identifier ),
            'Limit' => $limit,
            'Offset' => $offset,
        ),
        eZINI::instance( 'planete.ini' )->variable(
            'TreeSettings', 'PlanetariumNodeID'
        )
    );
    if ( empty( $posts ) )
        break;
    $offset += $limit;

    $cli->output( "Removing " . count( $posts ) . "...", false );
    $nodeIds = array();
    foreach ( $posts as $post )
    {
        $nodeIds[] = $post->attribute( 'node_id' );
    }
    eZContentObjectTreeNode::removeSubtrees( $nodeIds, false );
    $cli->output( " done." );
}

$script->shutdown();

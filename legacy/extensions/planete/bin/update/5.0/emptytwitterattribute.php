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
$twitterMsgIdentifier = 'twitter';

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
            'AttributeFilter' => array(
                array( "{$identifier}/{$twitterMsgIdentifier}", '!=', '' )
            ),
            'Limit' => $limit,
            'Offset' => $offset,
        ),
        eZINI::instance( 'planete.ini' )->variable(
            'TreeSettings', 'PlanetRootNodeID'
        )
    );
    if ( !$posts || empty( $posts ) )
        break;

    foreach ( $posts as $post )
    {
        $version = $post->attribute( 'object' )->createNewVersion();
        $dataMap = $version->attribute( 'data_map' );
        $cli->output( "{$post->attribute( 'name' )}: ", false );
        $cli->output( $dataMap['twitter']->content() );
        foreach ( $dataMap as $identifier => $attr )
        {
            if ( $identifier === $twitterMsgIdentifier )
            {
                $dataMap[$identifier]->fromString( '' );
            }
            $dataMap[$identifier]->store();
        }
        eZOperationHandler::execute(
            'content', 'publish',
            array(
                'object_id' => $post->attribute( 'object' )->attribute( 'id' ),
                'version' => $version->attribute( 'version' )
            )
        );
        $cli->output( 'Done' );
    }
}

$script->shutdown();

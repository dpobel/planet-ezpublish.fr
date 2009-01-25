#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "Fix version status error" ),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();
$script->initialize();

$planetINI = eZINI::instance( 'planete.ini' );
$rootNodeID = $planetINI->variable( 'TreeSettings', 'PlanetRootNodeID' );

$params = array( 'ClassFilterType' => 'include',
                 'ClassFilterArray' => array( 'post' ),
                 'Limit' => 100,
                 'Offset' => 0 );
$statusToText = array();
$statusToText[eZContentObjectVersion::STATUS_DRAFT] = 'Draft';
$statusToText[eZContentObjectVersion::STATUS_PUBLISHED] = 'Published';
$statusToText[eZContentObjectVersion::STATUS_ARCHIVED] = 'Archived';
$statusToText[eZContentObjectVersion::STATUS_INTERNAL_DRAFT] = 'Internal Draft';

while ( true )
{
    $list = eZContentObjectTreeNode::subTreeByNodeID( $params, $rootNodeID );
    if ( !is_array( $list ) || empty( $list ) )
    {
        break;
    }
    foreach( $list as $node )
    {
        $contentObject = $node->attribute( 'object' );
        $versions = $contentObject->attribute( 'versions' );
        $cli->output( $contentObject->attribute( 'name' ) );
        $cli->output( '  current_version=' . $contentObject->attribute( 'current_version' ) );
        if ( count( $versions ) == 1 && $versions[0]->attribute( 'status' ) == eZContentObjectVersion::STATUS_DRAFT )
        {
            // only one version, but the status is published
            $versions[0]->setAttribute( 'status', eZContentObjectVersion::STATUS_PUBLISHED );
            $versions[0]->store();
        }
        else
        {
            $versionNumber = count( $versions );
            $i = 1;
            foreach( $versions as $version )
            {
                if ( $i == $versionNumber )
                {
                    $version->setAttribute( 'status', eZContentObjectVersion::STATUS_PUBLISHED );
                    $version->store();
                    $contentObject->setAttribute( 'current', $version->attribute( 'version' ) );
                    $contentObject->store();
                }
                else
                {
                    $version->setAttribute( 'status', eZContentObjectVersion::STATUS_ARCHIVED );
                    $version->store();
                }
                $i++;
            }
        }
    }
    $params['Offset'] += $params['Limit'];
    eZContentObject::clearCache();
}

$script->shutdown();
?>

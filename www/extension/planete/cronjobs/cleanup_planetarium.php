<?php
/**
 * $Id$
 * $HeadURL$
 */

$planetINI = eZINI::instance( 'planete.ini' );
$planetariumNodeID = $planetINI->variable( 'TreeSettings', 'PlanetariumNodeID' );
$siteClassID = $planetINI->variable( 'ImportSettings', 'SiteClassID' );
$postClassID = $planetINI->variable( 'ImportSettings', 'PostClassID' );

$params = array( 'ClassFilterType' => 'include',
                 'ClassFilterArray' => array( $siteClassID ) );

$planetNodes = eZContentObjectTreeNode::subTreeByNodeID( $params, $planetariumNodeID );

eZLog::setMaxLogSize( $planetINI->variable( 'ImportSettings', 'MaxLogSize' ) );
$logFile = $planetINI->variable( 'ImportSettings', 'LogFile' );

foreach( $planetNodes as $planet )
{
    // keeping only 100 posts from any planet source
    // to avoid creating the same objet again and again
    $paramsPost = array( 'ClassFilterType' => 'include',
                         'ClassFilterArray' => array( $postClassID ),
                         'SortBy' => array( array( 'published', false ) ),
                         'Limit' => 10000, // to avoid http://issues.ez.no/14342
                         'Offset' => 100 );
    $postNodes = $planet->subTree( $paramsPost );  
    foreach( $postNodes as $post )
    {
        eZLog::write( 'Removing ' . $planet->attribute( 'name' ) . '/' . $post->attribute( 'name' ), $logFile );
        $post->removeNodeFromTree( false );
    }
}

?>

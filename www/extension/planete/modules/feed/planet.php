<?php
$db = eZDB::instance();

$ini = eZINI::instance();
$planetINI = eZINI::instance( 'planete.ini' );
$blogNodeID = $planetINI->variable( 'TreeSettings', 'BlogsNodeID' );

$cacheInfo = eZPlaneteUtils::rssCacheInfo();

$cache = new eZPHPCreator( $cacheInfo['cache-dir'], $cacheInfo['cache-file'] );
$cacheEnabled = ( $ini->variable( 'ContentSettings', 'ViewCaching' ) === 'enabled' );
if ( $cacheEnabled && $cache->canRestore() )
{
    $values = $cache->restore( array( 'Content' => 'content' ) );
    $content = $values['Content']; 
}
else
{
    $blogNode = eZContentObjectTreeNode::fetch( $blogNodeID );
    $params = array();
    $params['ClassFilterType'] = 'include';
    $params['ClassFilterArray'] = array( $planetINI->variable( 'ImportSettings', 'PostClassID' ) );
    $params['Limit'] = $planetINI->variable( 'PageSettings', 'PostByPage' );
    $params['SortBy'] = array( 'modified', false );
    $itemNodes = $blogNode->subTree( $params );
    $title = 'Flux RSS du Planet eZ Publish.fr';
    $urlBase = 'http://' . $ini->variable( 'SiteSettings', 'SiteURL' );

    $feed = new ezcFeed();
    $feed->title = $title;
    $feed->description = '';
    $feed->published = time();
    $feed->updated = $blogNode->attribute( 'modified_subnode' );
    $link = $feed->add( 'link' );
    $link->href = $urlBase;
    foreach( $itemNodes as $node )
    {
        $item = $feed->add( 'item' );
        $dataMap = $node->attribute( 'data_map' );
        $item->title = htmlspecialchars( $node->attribute( 'name' ), ENT_NOQUOTES, 'UTF-8' );
        $guid = $item->add( 'id' );
        $guid->id = $node->attribute( 'remote_id' );
        $guid->isPermaLink = "false";
        $item->link = htmlspecialchars( $dataMap['url']->attribute( 'content' ), ENT_NOQUOTES, 'UTF-8' );
        $item->pubDate = $node->attribute( 'object' )->attribute( 'published' );
        $item->published = $node->attribute( 'object' )->attribute( 'published' );
        $item->description = eZPlaneteUtils::cleanRewriteXHTML( $dataMap['html']->attribute( 'content' ),
                                                                $dataMap['url']->attribute( 'content' ) );
        $parentNode = $node->attribute( 'parent' );
        $dataMapParent = $parentNode->attribute( 'data_map' );
        $dublinCore = $item->addModule( 'DublinCore' );
        $creator = $dublinCore->add( 'creator' );
        $creator->name = htmlspecialchars( $dataMapParent['url']->attribute( 'data_text' ), ENT_NOQUOTES, 'UTF-8' );
        $creator->language = 'fr';
    }
    $content = $feed->generate( 'rss2' );
    $cache->addVariable( 'content', $content );
    $cache->store();
}
$cache->close();
header( 'Content-Type: application/rss+xml' );
echo $content;
eZExecution::cleanExit();
?>

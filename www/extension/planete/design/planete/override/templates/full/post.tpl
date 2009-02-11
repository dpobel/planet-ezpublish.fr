{cache-block keys=array( 'node', $node.node_id ) expiry=0 subtree_expiry=$node.node_id}
<div class="post">
    <h1><a href={$node.data_map.url.content|wash|ezurl()}><span>{$node.parent.name|wash()}</span>&nbsp;: {$node.name|wash()}</a></h1>
    <div class="post-content">{attribute_view_gui attribute=$node.data_map.html mode='html' base_url=$node.parent.data_map.url.content}</div>
    <div class="info">
        <img src={'images/bookmark.png'|ezdesign} alt="Bookmark logos" usemap="#bookmark{$node.node_id}" />
        <map id="bookmark{$node.node_id}" name="bookmark{$node.node_id}">
        {def $start = 0
             $size = ezini( 'PageSettings', 'BookmarkImgSize', 'planete.ini' )
             $end = $size
             $padding = ezini( 'PageSettings', 'BookmarkImgPadding', 'planete.ini' )
             $urls = ezini( 'PageSettings', 'BookmarkURL', 'planete.ini' )
             $post_url = $node.data_map.url.content
             $post_name = $node.name}
        {foreach $urls as $name => $url}
            <area shape="rect" coords="{$start},0,{$end},15" href="{$url|bookmarkize( $post_url, $post_name )|wash()}" title="{$name|wash()}" alt="{$name|wash()}" />
            {set $start = $start|sum( $size )|sum( $padding )}
            {set $end = $start|sum( $size )}
        {/foreach}
        {undef $start $size $end $padding $urls $post_url $post_name}
        </map>
        Publié par <a href={$node.parent.data_map.url.content|ezurl()}>{$node.parent.name|wash()}</a> le {$node.object.published|l10n( 'shortdatetime' )}
    </div>
</div>
{/cache-block}

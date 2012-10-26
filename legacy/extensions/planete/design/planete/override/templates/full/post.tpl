{cache-block keys=array( 'node', $node.node_id ) expiry=0 subtree_expiry=$node.node_id}
<article class="post">
    <h1><a href={$node.data_map.url.content|wash|ezurl()}><span>{$node.parent.name|wash()}&nbsp;: </span>{$node.name|wash()}</a></h1>
    <div>{attribute_view_gui attribute=$node.data_map.html mode='html' base_url=$node.parent.data_map.url.content}</div>
    <div class="info">
        Publié par <a href={$node.parent.data_map.url.content|ezurl()}>{$node.parent.name|wash()}</a> le <time datetime="{$node.object.published|datetime( 'custom', '%c' )}">{$node.object.published|l10n( 'shortdatetime' )}</time>
        <div class="social">
            <iframe allowtransparency="true" frameborder="0" scrolling="no"
               src="//platform.twitter.com/widgets/tweet_button.html?text={$node.name|wash()}&amp;url={$node.data_map.url.content|wash|ezurl( 'no' )}&amp;via=pl_ezpublish_fr&amp;lang=fr&amp;hashtags=ezpublish"
               style="width:130px; height:20px;"></iframe>
            <div class="g-plusone" data-size="medium" data-href={$node.data_map.url.content|wash|ezurl()}></div>
        </div>
    </div>
</article>
<hr />
{/cache-block}

{cache-block keys=array( 'node', $node.node_id ) expiry=0 subtree_expiry=$node.node_id}
<div class="post">
    <h1><a href={$node.data_map.url.content|wash|ezurl()}><span>{$node.parent.name|wash()}</span>&nbsp;: {$node.name|wash()}</a></h1>
    <div class="post-content">{attribute_view_gui attribute=$node.data_map.html mode='html' base_url=$node.parent.data_map.url.content}</div>
    <div class="info">Publié par <a href={$node.parent.data_map.url.content|ezurl()}>{$node.parent.name|wash()}</a> le {$node.object.published|l10n( 'shortdatetime' )}</div>
</div>
{/cache-block}

{cache-block keys=array( 'line', $node.node_id ) subtree_expiry=$node.node_id
             expiry=0}
<dt><a href={$node.data_map.url.content|ezurl()}>{$node.name|wash()}</a></dt>
<dd>{$node.data_map.html.content|strip_tags|entity_decode|simplify|trim|shorten(300)|wash()}</dd>
{/cache-block}

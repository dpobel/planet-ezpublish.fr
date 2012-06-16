{def $sites = fetch( content, list, hash( 'parent_node_id', $node.node_id,
                                          'sort_by', array( 'modified_subnode', false() ),
                                          'class_filter_type', include,
                                          'class_filter_array', array( 'site' ) ) )
     $posts = array()
     $meta_description = $node.name
}
<h1 class="title-page">{$node.name|wash()}</h1>
<article>
{foreach $sites as $site}
    {cache-block keys=array( 'node', $site.node_id ) expiry=0 subtree_expiry=$site.node_id}
    {set $posts = fetch( content, list, hash( 'parent_node_id', $site.node_id ,
                                              'class_filter_type', include,
                                              'class_filter_array', array( 'post' ),
                                              'sort_by', array( 'modified', false() ),
                                              'limit', 5 ) )}
    <div>
        <h2><a href={$site.url_alias|ezurl()}>{$site.name|wash()}</a> : les derniers billets</h2>
    {if $posts|not()}
        <p>Pas encore de billet</p>
    {else}
        <ul>
        {foreach $posts as $post}
            <li><a href={$post.data_map.url.content|wash()|ezurl()}>{$post.name|wash()}</a></li>
        {/foreach}
        </ul>
    {/if}
    </div>
    {/cache-block}
    {set $meta_description = concat( $meta_description, ', ', $site.name )}
{/foreach}
{undef $sites $posts}
{* persistent variables pour les méta de la page *}
{set scope='global' persistent_variable=hash( 'title_page', $node.name,
                                              'meta_description', $meta_description|trim )}
</article>

{def $by_page = ezini( 'PageSettings', 'PostByBlogPage', 'planete.ini' )
     $posts_count = fetch( content, list_count, hash( parent_node_id, $node.node_id,
                                                      class_filter_type, include,
                                                      class_filter_array, array( 'post' ) ) )
     $posts = fetch( content, list, hash( parent_node_id, $node.node_id,
                                          class_filter_type, include,
                                          class_filter_array, array( 'post' ),
                                          sort_by, array( 'published', false() ),
                                          offset, $view_parameters.offset,
                                          limit, $by_page ) )
     $title = concat( 'Articles de ', $node.name )
     $description = $title}
<h1 class="title-page"><a href={$node.data_map.url.content|ezurl()}>Articles de &laquo;&nbsp;{$node.name|wash()}&nbsp;&raquo;</a> &mdash; <a href={$node.data_map.rss.content|ezurl()}>Flux RSS</a></h1>
<article>
    <dl>
    {foreach $posts as $post}
        {node_view_gui content_node=$post view='line'}
        {set $description = concat( $description, ', ', $post.name )}
    {/foreach}
    </dl>
</article>
{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri=$node.url_alias
         item_count=$posts_count
         view_parameters=$view_parameters
         item_limit=$by_page}

{* persistent variables pour les méta de la page *}
{set scope='global' persistent_variable=hash( 'title_page', $title,
                                              'meta_description', $description|shorten( 300 )|simplify|trim )}

{undef $posts_count $posts $by_page}

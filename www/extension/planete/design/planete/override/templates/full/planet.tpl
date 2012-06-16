{def $posts_limit = ezini( 'PageSettings', 'PostByPage', 'planete.ini' )
     $blogs_node_id = ezini( 'TreeSettings', 'BlogsNodeID', 'planete.ini' )
     $posts = fetch( content, tree, hash( 'parent_node_id', $blogs_node_id,
                                          'class_filter_type', 'include',
                                          'class_filter_array', array( 'post' ),
                                          'sort_by', array( 'published', false() ),
                                          'offset', $view_parameters.offset,
                                          'limit', $posts_limit ) ) 
     $posts_count = fetch( content, tree_count, hash( 'parent_node_id', $blogs_node_id,
                                                      'class_filter_type', 'include',
                                                      'class_filter_array', array( 'post' ) ) )
     $page = $view_parameters.offset|div( $posts_limit )|ceil()|inc()
     $title_page = cond( $view_parameters.offset|eq( 0 ), $node.name, concat( $node.name, ' (Page ', $page, ')' ) )
     $meta_description = $title_page}
{if $posts}
    <h1 class="title-page">Planète eZ Publish{if $page|ne( 1 )} (page {$page}){/if}</h1>
    {foreach $posts as $post_node}
        {node_view_gui content_node=$post_node view='full'}
        {set $meta_description = concat( $meta_description, ', ', $post_node.name )}
    {/foreach}
{/if}

{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri=$node.url_alias
         item_count=$posts_count
         view_parameters=$view_parameters
         item_limit=$posts_limit}

{* persistent variables pour les méta de la page *}
{set scope='global' persistent_variable=hash( 'title_page', $title_page,
                                              'meta_description', $meta_description )}

{undef $posts $posts_count}

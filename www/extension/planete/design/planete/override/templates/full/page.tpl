<h1 class="title-page">{$node.name|wash()}</h1>
<article class="post">
    <div>
        {attribute_view_gui attribute=$node.data_map.content}
    </div>
{* persistent variables pour les méta de la page *}
{set scope='global' persistent_variable=hash( 'title_page', $node.name,
                                              'meta_description', $node.data_map.content.content.output.output_text|strip_tags|shorten( 200 )|simplify|trim )}
</article>

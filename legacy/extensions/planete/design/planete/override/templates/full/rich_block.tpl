<article>
<h1>{$node.name|wash()}</h1>
<div>
    {attribute_view_gui attribute=$node.data_map.text}
</div>
</article>
{set scope='global' persistent_variable=hash( 'title_page', $node.name,
                                              'meta_description', $node.data_map.text.content.output.output_text|strip_tags|simplify|trim )}

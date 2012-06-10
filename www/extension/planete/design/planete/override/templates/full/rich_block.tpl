<div class="post">
<h1><span>{$node.name|wash()}</span></h1>
    <div class="post-content">
        {attribute_view_gui attribute=$node.data_map.text}
    </div>
</div>
{set scope='global' persistent_variable=hash( 'title_page', $node.name,
                                              'meta_description', $node.data_map.text.content.output.output_text|strip_tags|simplify|trim )}

<article>
    <h1><a href={$node.url_alias|ezurl()}>{$node.name|wash()}</a></h1>
    <div>
        {attribute_view_gui attribute=$node.data_map.description}
    </div>
    <div>
        {include uri="design:infocollection_validation.tpl"}
        <form action={'content/action'|ezurl()} method="post">
        <p class="help">Tous les champs sont obligatoires.</p>
        <p>
            <label for="field_{$node.data_map.email.id}">Adresse e-mail&nbsp;:</label>
            {attribute_view_gui attribute=$node.data_map.email}
        </p>
        <p>
            <label for="field_{$node.data_map.subject.id}">Sujet&nbsp;:</label>
            {attribute_view_gui attribute=$node.data_map.subject}
        </p>
        <p>
            <label for="field_{$node.data_map.text.id}">Texte&nbsp;:</label>
            {attribute_view_gui attribute=$node.data_map.text}
        </p>
        <p class="buttons">
            <input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
            <input type="hidden" name="ContentObjectID" value="{$node.contentobject_id}" />
            <input type="hidden" name="ViewMode" value="full" />
            <input type="submit" class="yui3-button" value="Envoyer" name="ActionCollectInformation" />
        </p>
        </form>
    </div>
{* persistent variables pour les méta de la page *}
{set scope='global' persistent_variable=hash( 'title_page', $node.name,
                                              'meta_description', $node.data_map.description.content.output.output_text|strip_tags|shorten( 200 )|simplify|trim )}
</article>

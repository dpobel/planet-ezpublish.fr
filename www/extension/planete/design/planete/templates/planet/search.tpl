<div class="content-search">
    <form action={"planet/search/"|ezurl} method="get">
        <fieldset class="search">
            <legend>Recherche</legend>
            <p>
                <input class="text" type="text" name="SearchText" value="{$search_text|wash}" />
                <input class="button" type="submit" value="Rechercher" />
            </p>
        </fieldset>
    </form>
</div>
<div class="post">
    <h1 class="search-title">{if ezhttp_hasvariable( 'SearchText', 'get' )}Recherche de &laquo;&nbsp;{ezhttp( 'SearchText', 'get' )|wash()}&nbsp;&raquo;&nbsp;: {/if}{$search_count} résultat{cond( $search_count|gt( 1 ), 's', '' )}</h1>
    <div class="post-content">
    {section show=$stop_word_array}
        <p>
        {"The following words were excluded from the search"|i18n("design/base")}:
        {section name=StopWord loop=$stop_word_array}
            {$StopWord:item.word|wash}
            {delimiter}, {/delimiter}
        {/section}
        </p>
    {/section}
    </div>
    {def $meta_description = 'Résultat de la recherche'}
    {foreach $search_result as $item}
       {node_view_gui view=full content_node=$item}
       {set $meta_description = concat( $meta_description, ', ', $item.name )}
    {/foreach}
    {if ezhttp_hasvariable( 'SearchText', 'get' )}
        {if $search_count|eq( 0 )}
            {set scope='global' persistent_variable=hash( 'title_page', concat( 'Recherche de "', ezhttp( 'SearchText', 'get' ), '"' ),
                                                          'meta_description', concat( 'Aucun résultat pour la recherche de ', ezhttp( 'SearchText', 'get' ) ) )}
        {else}
            {set scope='global' persistent_variable=hash( 'title_page', concat( 'Recherche de "', ezhttp( 'SearchText', 'get' ), '"' ),
                                                          'meta_description', $meta_description )}
        {/if}
    {else}
        {set scope='global' persistent_variable=hash( 'title_page', 'Rechercher sur Planet eZ Publish.fr',
                                                      'meta_description', 'Moteur de recherche de Planet eZ Publish.fr' )}
    {/if}
    {include name=Navigator
         uri='design:navigator/google.tpl'
         page_uri='planet/search'
         page_uri_suffix=concat( '?SearchText=', $search_text|urlencode )
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>

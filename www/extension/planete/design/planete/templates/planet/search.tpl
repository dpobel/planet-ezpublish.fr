<div class="content-search">
    <form action={"planet/search/"|ezurl} method="get">
        <fieldset class="search">
            <legend>Recherche</legend>
            <p>
                <input class="text" type="text" name="SearchText" value="{$search_text|wash}" />
                <input class="button" name="SearchButton" type="submit" value="Rechercher" />
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

    {def $meta_description = 'Résultat de la recherche, '}
    {foreach $search_result as $item}
       {node_view_gui view=full content_node=$item}
       {set $meta_description = concat( $meta_description, ', ', $item.name )}
    {/foreach}
    {if ezhttp_hasvariable( 'SearchText', 'get' )}
        {set scope='global' persistent_variable=hash( 'title_page', concat( 'Recherche de "', ezhttp( 'SearchText', 'get' ), '"' ),
                                                      'meta_description', $meta_description )}
    {else}
        {set scope='global' persistent_variable=hash( 'title_page', 'Recherche',
                                                      'meta_description', 'Aucun résultat' )}
    {/if}
    {include name=Navigator
         uri='design:navigator/google.tpl'
         page_uri='/planete/search'
         page_uri_suffix=concat('?SearchText=',$search_text|urlencode,$search_timestamp|gt(0)|choose('',concat('&SearchTimestamp=',$search_timestamp)), '&SubTreeArray=',$search_subtree_array|implode( ',' ) )
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>

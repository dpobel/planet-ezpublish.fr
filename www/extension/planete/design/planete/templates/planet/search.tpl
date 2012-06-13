<form action={"planet/search/"|ezurl} method="get">
    <fieldset>
        <legend>Recherche</legend>
        <p>
            <input type="text" name="SearchText" value="{$search_text|wash}" />
        </p>
        <p>Date de publication&nbsp;:
            <ul>
                <li>
                    <input type="radio" name="DateFilter" value="0" id="f1"{cond( $search_date_filter|eq( 0 ), ' checked="checked"', '' )} />
                    <label for="f1">à tout moment</label>
                </li>
                <li>
                    <input type="radio" name="DateFilter" value="1" id="f2"{cond( $search_date_filter|eq( 1 ), ' checked="checked"', '' )} />
                    <label for="f2">depuis hier</label>
                </li>
                <li>
                    <input type="radio" name="DateFilter" value="2" id="f3"{cond( $search_date_filter|eq( 2 ), ' checked="checked"', '' )} />
                    <label for="f3">depuis moins d'1 semaine</label>
                </li>
                <li>
                    <input type="radio" name="DateFilter" value="3" id="f4"{cond( $search_date_filter|eq( 3 ), ' checked="checked"', '' )} />
                    <label for="f4">depuis moins de 1 mois</label>
                </li>
                <li>
                    <input type="radio" name="DateFilter" value="4" id="f5"{cond( $search_date_filter|eq( 4 ), ' checked="checked"', '' )} />
                    <label for="f5">depuis moins de 3 derniers mois</label>
                </li>
                <li>
                    <input type="radio" name="DateFilter" value="5" id="f6"{cond( $search_date_filter|eq( 5 ), ' checked="checked"', '' )} />
                    <label for="f6">depuis moins d'an</label>
                </li>
            </ul>
        </p>
        <p>
            <input type="submit" value="Rechercher" />
        </p>
    {if $search_extras.spellcheck_collation}
        <p>
         {def $spell_url=concat('/planet/search/',$search_text|count_chars()|gt(0)|choose('',concat('?SearchText=',$search_extras.spellcheck_collation|urlencode)))|ezurl}
         Vouliez-vous dire <b><a href={$spell_url}>{$search_extras.spellcheck_collation}</a></b>&nbsp;?
        {undef $spell_url}
        </p>
    {/if}
    </fieldset>
    {if $search_extras.facet_fields.0.queryLimit|count}
    <fieldset>
        <legend>Affiner la recherche</legend>
        <ul>
        {foreach $search_extras.facet_fields.0.nameList as $value}
        <li><a href={concat(
            'planet/search?SearchText=', $search_text,
            '&DateFilter=', $search_date_filter,
            '&Filter[]=', $search_extras.facet_fields.0.queryLimit[$value]
        )|ezurl()}>{$value|wash}</a> ({$search_extras.facet_fields.0.countList[$value]})</li>
        {/foreach}
        </ul>
    </fieldset>
    {/if}
</form>
<div>
    <h1>
    {if ezhttp_hasvariable( 'SearchText', 'get' )}
        {def $text = ezhttp( 'SearchText', 'get' )}
        Recherche de &laquo;&nbsp;<a class="search-rs" href={concat( 'planet/search?SearchText=', $text|urlencode )|ezurl()}>{$text|wash()}</a>&nbsp;&raquo;&nbsp;:
        {undef $text}
    {/if}
    {if $search_count|ne( 0 )}
        {$search_count} résultat{cond( $search_count|gt( 1 ), 's', '' )}
    {else}
        Aucun résultat
    {/if}
    </h1>
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

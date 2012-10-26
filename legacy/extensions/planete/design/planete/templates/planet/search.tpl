{ezscript( 'ezjsc::yui3' )}
{literal}
<script>
YUI3_config.modules['planet-fieldset'] = {
    name: 'planet-fieldset',
    type: 'js',
    requires: ['node', 'transition'],
{/literal}
    fullpath: "{ezscriptfiles( 'planetfieldset.js', 3, true ).0}"
{literal}
}
YUI(YUI3_config).use('planet-fieldset');
</script>
{/literal}
<section>
    <h1 class="title-page">
    {if ezhttp_hasvariable( 'SearchText', 'get' )}
        {def $text = ezhttp( 'SearchText', 'get' )}
        Recherche de
        &laquo;&nbsp;<a class="search-rs" href={concat(
            'planet/search?SearchText=', $text|urlencode,
            '&DateFilter=', $search_date_filter,
            '&Author=', $search_author|urlencode
        )|wash|ezurl()}>{$text|wash()}</a>&nbsp;&raquo;&nbsp;:
        {undef $text}
    {/if}
    {if $search_count|ne( 0 )}
        {$search_count} résultat{cond( $search_count|gt( 1 ), 's', '' )}
    {else}
        Aucun résultat
    {/if}
    </h1>
    {if $search_extras.spellcheck_collation}
        <p class="spell help">
         {def $spell_url=concat('/planet/search/',$search_text|count_chars()|gt(0)|choose('',concat('?SearchText=',$search_extras.spellcheck_collation|urlencode)))|ezurl}
         Vouliez-vous dire <b><a href={$spell_url}>{$search_extras.spellcheck_collation}</a></b>&nbsp;?
        {undef $spell_url}
        </p>
    {/if}


<form action={"planet/search/"|ezurl} method="get" class="search">
    <fieldset class="collapsible{cond( and( $search_text|ne( '' ), $search_count|gt( 0 ) ), ' collapsed', '' )}">
        <legend>Recherche</legend>
        <div class="inner-collapsible">
        <p class="keywords">
            <input type="search" name="SearchText" value="{$search_text|wash}" placeholder="Mots clés" />
        </p>
        <p>Date de publication&nbsp;:</p>
        <ul class="date-filter">
            <li>
                <label for="f1">
                <input type="radio" name="DateFilter" value="0" id="f1"{cond( $search_date_filter|eq( 0 ), ' checked="checked"', '' )} />
                à tout moment
                </label>
            </li>
            <li><label for="f2">
                <input type="radio" name="DateFilter" value="1" id="f2"{cond( $search_date_filter|eq( 1 ), ' checked="checked"', '' )} />
                depuis hier
                </label>
            </li>
            <li>
                <label for="f3">
                <input type="radio" name="DateFilter" value="2" id="f3"{cond( $search_date_filter|eq( 2 ), ' checked="checked"', '' )} />
                depuis moins d'1 semaine
                </label>
            </li>
            <li>
                <label for="f4">
                <input type="radio" name="DateFilter" value="3" id="f4"{cond( $search_date_filter|eq( 3 ), ' checked="checked"', '' )} />
                depuis moins de 1 mois
                </label>
            </li>
            <li>
                <label for="f5">
                <input type="radio" name="DateFilter" value="4" id="f5"{cond( $search_date_filter|eq( 4 ), ' checked="checked"', '' )} />
                depuis moins de 3 derniers mois
                </label>
            </li>
            <li>
                <label for="f6">
                <input type="radio" name="DateFilter" value="5" id="f6"{cond( $search_date_filter|eq( 5 ), ' checked="checked"', '' )} />
                depuis moins d'an
                </label>
            </li>
        </ul>
        <p class="buttons">
            <input type="submit" class="yui3-button" value="Rechercher" />
        </p>
        </div>
    </fieldset>
    {if $search_extras.facet_fields.0.queryLimit|count}
    <fieldset class="collapsible{cond( $search_author|eq( '' ), ' collapsed', '' )}">
        <legend>Filtrer par auteur</legend>
        <div class="inner-collapsible">
        <ul class="authors">
        {foreach $search_extras.facet_fields.0.nameList as $value}
        <li>
            {if $value|eq( $search_author )}
            <a class="remove" href={concat(
                'planet/search?SearchText=', $search_text|urlencode,
                '&DateFilter=', $search_date_filter
            )|wash|ezurl()}>Supprimer le filtre "{$value|wash}"</a>
            {else}
            <a href={concat(
                'planet/search?SearchText=', $search_text|urlencode,
                '&DateFilter=', $search_date_filter,
                '&Author=', $value|urlencode
            )|wash|ezurl()}>{$value|wash}&nbsp;({$search_extras.facet_fields.0.countList[$value]})</a>
            {/if}
        </li>
        {/foreach}
        </ul>
        </div>
    </fieldset>
    {/if}
</form>
<div class="search-result">
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
         page_uri_suffix=concat( '?SearchText=', $search_text|urlencode, '&DateFilter=', $search_date_filter, '&Author=', $search_author|urlencode )
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>
</section>


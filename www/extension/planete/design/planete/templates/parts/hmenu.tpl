{cache-block keys=array( 'hmenu', cond( is_set( $module_result.node_id ), $module_result.node_id, 0 ) )
             expiry=0
             subtree_expiry=ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' )}
{def $menu = fetch( content, list, hash( 'parent_node_id', ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' ),
                                         'sort_by', array( 'priority', true() ),
                                         'class_filter_type', 'include',
                                         'class_filter_array', ezini( 'MenuContentSettings', 'TopIdentifierList', 'menu.ini' ) ) )
     $current_node_id = cond( is_set( $module_result.node_id ), $module_result.node_id, 0 )
}
<header>
    <div id="hmask"></div>
    <p><a href={'/'|ezurl()} title="Planet eZ Publish.fr, ze french corner !">Planet eZ Publish.fr, ze french corner !</a></p>
    <ul>
        <li{cond( $current_node_id|eq( 2 ), ' class="selected"', '' )}><a href={'/'|ezurl()}>Accueil</a></li>
    {foreach $menu as $element}
        <li{cond(
            $current_node_id|eq( $element.node_id ),
            concat( ' class="selected ', $element.url_alias, '"'),
            concat( ' class="', $element.url_alias, '"' ) )}><a href={$element.url_alias|ezurl()}>{$element.name|wash()}</a></li>
    {/foreach}
        <li class="inline-search">
        <form action={'planet/search'|ezurl()} method="get">
            <input type="search" name="SearchText" value="{cond( ezhttp_hasvariable( 'SearchText', 'get' ), ezhttp( 'SearchText', 'get' )|wash(), '' )}" placeholder="Rechercher" />
            <input type="submit" class="yui3-button" value="Go!" />
        </form>
        </li>
    </ul>
</header>
{undef $menu $current_node_id}
{/cache-block}

{*
 * $Id$
 * $HeadURL$
 *}
<div id="menu">
    <div class="block flux">
        <p>
            <a href={'feed/planet'|ezurl()} id="rss" title="Suivez le Planet par le flux RSS"><span>Flux RSS</span></a>
            <a href="http://twitter.com/pl_ezpublish_fr" id="twitter" title="Suivez le Planet sur Twitter"><span>Twitter du Planet eZ Publish.fr</span></a>
        </p>
    </div>
    {cache-block keys=array( 'menu', ezini( 'TreeSettings', 'BlogsNodeID', 'planete.ini' ) )
                 expiry=0 subtree_expiry=ezini( 'TreeSettings', 'BlogsNodeID', 'planete.ini' )}
    <div class="block">
        {def $blog = fetch( content, node, hash( 'node_id', ezini( 'TreeSettings', 'BlogsNodeID', 'planete.ini' ) ) )
             $sites = fetch( content, list, hash( 'parent_node_id', $blog.node_id,
                                                  'class_filter_type', include,
                                                  'class_filter_array', array( 'site' ),
                                                  'sort_by', array( 'modified_subnode', false() ) ) )}

        <h1><a href={$blog.url_alias|ezurl()}>{$blog.name|wash()}</a></h1>
        <ul>
        {foreach $sites as $site}

            <li><a href={$site.data_map.url.content|ezurl()}>{$site.name|wash()}</a></li>
        {/foreach}
        {undef $blog $sites}
        </ul>
    </div>
    {/cache-block}
    <div class="block">
        {def $blocks = fetch( content, list, hash( 'parent_node_id', ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' ),
                                                   'class_filter_type', include,
                                                   'class_filter_array', array( 'rich_block' ),
                                                   'sort_by', array( 'priority', true() ) ) )}
        {foreach $blocks as $block}
            {node_view_gui content_node=$block view='line'}
        {/foreach}
        {undef $blocks}
    </div>
    <div class="block">
        <h1><a href={'planet/search'|ezurl()}>Recherche</a></h1>
        <form id="search" action={'planet/search'|ezurl()} method="get">
        <p>
            <input type="text" class="text" name="SearchText" value="{cond( ezhttp_hasvariable( 'SearchText', 'get' ), ezhttp( 'SearchText', 'get' )|wash(), '' )}" />
            <input type="submit" class="button" value="Go !" />
        </p>
        </form>
    </div>
    {cache-block keys=array( 'menu', ezini( 'TreeSettings', 'PlanetariumNodeID', 'planete.ini' ) )
                 expiry=0 subtree_expiry=ezini( 'TreeSettings', 'PlanetariumNodeID', 'planete.ini' )}
    <div class="block">
        {def $planetarium = fetch( content, node, hash( 'node_id', ezini( 'TreeSettings', 'PlanetariumNodeID', 'planete.ini' ) ) )
             $planets = fetch( content, list, hash( 'parent_node_id', $planetarium.node_id,
                                                    'class_filter_type', include,
                                                    'class_filter_array', array( 'site' ),
                                                    'sort_by', array( 'published', true() ) ) )}

        <h1><a href={$planetarium.url_alias|ezurl()}>{$planetarium.name|wash()}</a></h1>
        <ul>
        {foreach $planets as $planet}

            <li><a href={$planet.data_map.url.content|ezurl()}>{$planet.name|wash()}</a></li>
        {/foreach}
        {undef $planetarium $planets}
        </ul>
    </div>
    {/cache-block}
</div>

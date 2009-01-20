{cache-block keys='hmenu' expiry=0 subtree_expiry=ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' )}
{def $menu = fetch( content, list, hash( 'parent_node_id', ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' ),
                                         'sort_by', array( 'priority', true() ),
                                         'class_filter_type', 'include',
                                         'class_filter_array', ezini( 'MenuContentSettings', 'TopIdentifierList', 'menu.ini' ) ) )}
<div id="header">
    <p><a href={'/'|ezurl()} title="Planet eZ Publish.fr, ze french corner !"><span>Planet eZ Publish<strike>.org</strike>.fr, ze french corner !</span></a></p>
    <ul>
        <li><a href={'/'|ezurl()}>Accueil</a></li>
    {foreach $menu as $element}
        <li><a href={$element.url_alias|ezurl()}>{$element.name|wash()}</a></li>
    {/foreach}
    </ul>
</div>
{undef $menu}
{/cache-block}

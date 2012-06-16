<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
{if is_set( $module_result.content_info.persistent_variable )}

    <title>{$module_result.content_info.persistent_variable.title_page|wash()} - {$site.title|wash()}</title>
    <meta name="description" content="{$module_result.content_info.persistent_variable.meta_description|wash()}" />
{else}

    <title>{$module_result.path|reverse().0.text|wash()} - {$site.title|wash()}</title>
{/if}
{if and( is_set( $module_result.node_id ),
         $module_result.node_id|eq( ezini( 'TreeSettings', 'PlanetRootNodeID', 'planete.ini' ) ),
         $module_result.view_parameters.offset|eq( 0 ) )}
    {* à la racine on met quelques mot clés pour faciliter l'inscription à quelques annuaires *}

    <meta name="keywords" content="{$site.meta.keywords|wash()}" />
{/if}
    {ezcss_load( ezini( 'StylesheetSettings', 'FrontendCSSFileList', 'design.ini' ) )}
    {if ezini( 'DebugSettings', 'DebugOutput' )|eq( 'enabled' )}

    <link rel="stylesheet" type="text/css" href="{'stylesheets/debug.css'|ezdesign( 'no' )}" />
    {/if}

    <link rel="alternate" type="application/rss+xml" title="Flux RSS" href={'feed/planet'|ezurl()} />
    <meta name="robots" content="noodp" />
    <meta name="generator" content="eZ Publish" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link rel="Shortcut icon" href={'favicon.ico'|ezimage()} type="image/x-icon" />
</head>
<body>
{include uri="design:parts/hmenu.tpl"}
<div class="yui3-g">
    <section class="yui3-u-3-4 {cond( is_set( $module_result.node_id ), $module_result.content_info.class_identifier, 'module' )}">
        {$module_result.content}
    </section>
    {include uri="design:parts/menu.tpl"}
</div>
<footer>
    <p>Mise sur orbite par <a href="http://ez.no">eZ Publish</a> - Conception, développement et hébergement par <a href="http://pwet.fr/cv">Damien Pobel</a></p>
</footer>
<!--DEBUG_REPORT-->
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
{*
 * $Id$
 * $HeadURL$
 *}
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
{def $revision = ezini( 'PageSettings', 'Revision', 'planete.ini',, true() )}
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

    <link rel="stylesheet" type="text/css" href="{ezini( 'StylesheetSettings', 'SiteCSS', 'design.ini' )|ezdesign( 'no' )}?rev={$revision}" />
    {if ezini( 'DebugSettings', 'DebugOutput' )|eq( 'enabled' )}

    <link rel="stylesheet" type="text/css" href="{'stylesheets/debug.css'|ezdesign( 'no' )}?rev={$revision}" />
    {/if}
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="{'stylesheets/ie6.css'|ezdesign( 'no' )}?rev={$revision}" />
    <![endif]-->
{undef $revision}

    <link rel="alternate" type="application/rss+xml" title="Flux RSS" href={'feed/planet'|ezurl()} />
    <meta name="robots" content="noodp" />
    <meta name="MSSmartTagsPreventParsing" content="TRUE" />
    <meta name="generator" content="eZ Publish" />
    <meta http-equiv="Content-language" content="fr-FR" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link rel="Shortcut icon" href={'favicon.ico'|ezimage()} type="image/x-icon" />
</head>
<body>
<div>
{include uri="design:parts/hmenu.tpl"}
<br class="spacer" />
<div id="planet">
    <div id="main">
    {$module_result.content}
    </div>
    {include uri="design:parts/menu.tpl"}
    <br class="spacer" />
    <div id="footer">
        <p>Mise sur orbite par <a href="http://ez.no">eZ Publish</a> - Conception, développement et hébergement par <a href="http://pwet.fr/cv">Damien POBEL</a></p>
    </div>
</div>
</div>
<!--DEBUG_REPORT-->
</body>
</html>

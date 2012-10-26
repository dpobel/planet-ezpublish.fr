<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <!--[if lt IE 9]>
    <script src={'javascript/html5shiv.js'|ezdesign}></script>
    <![endif]-->
</head>
<body>
{include uri="design:parts/hmenu.tpl"}
<div class="yui3-g">
    <div id="content" class="yui3-u-3-4">
    {$module_result.content}
    </div>
    {include uri="design:parts/menu.tpl"}
</div>
<footer>
    <p>Mise sur orbite par <a href="http://share.ez.no">eZ Publish {fetch( setup, version )}</a> - Conception, développement et hébergement par <a href="http://pwet.fr/cv">Damien Pobel</a></p>
</footer>
{literal}
<script>
  window.___gcfg = {lang: 'fr'};
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32710880-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var load = function(src) {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = src;
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    }
    load('http://apis.google.com/js/plusone.js');
    load('http://www.google-analytics.com/ga.js');
   })();
</script>
{/literal}
<!--DEBUG_REPORT-->
</body>
</html>

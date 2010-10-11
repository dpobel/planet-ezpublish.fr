<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$site.http_equiv.Content-language|wash}" lang="{$site.http_equiv.Content-language|wash}">
<head>

{* Do some uncacheable left + right menu stuff before cache-block's *}
{def $ui_context_edit      = eq( $ui_context, 'edit' )
     $content_edit         = and( $ui_context_edit, eq( $ui_component, 'content' ) )
     $hide_right_menu      = first_set( $module_result.content_info.persistent_variable.extra_menu, $ui_context_edit|not )|not
     $collapse_right_menu  = ezpreference( 'admin_right_menu_show' )|not
     $admin_left_size      = ezpreference( 'admin_left_menu_size' )
     $admin_theme          = ezpreference( 'admin_theme' )
     $left_size_hash       = 0
     $user_hash = concat( $current_user.role_id_list|implode( ',' ), ',', $current_user.limited_assignment_value_list|implode( ',' ) )
}

{if $hide_right_menu}
    {set $collapse_right_menu = false()}
{/if}

{if and( $ui_context_edit|not, or( $collapse_right_menu, $admin_left_size ))}
<style type="text/css">
{if $collapse_right_menu}
    div#page div#rightmenu  {ldelim} width: 18px; {rdelim}
    div#page div#maincolumn {ldelim} margin-right: 17px; {rdelim}
{/if}
{if $admin_left_size}
    {def $left_menu_widths = ezini( 'LeftMenuSettings', 'MenuWidth', 'menu.ini')}
    {if is_set( $left_menu_widths[$admin_left_size] )}
        {set $left_size_hash = $left_menu_widths[$admin_left_size]}
        div#leftmenu   {ldelim} width: {$left_size_hash|int}em; {rdelim}
        div#maincontent {ldelim} margin-left: {$left_size_hash|int}em; {rdelim}
    {else}
        div#page div#leftmenu   {ldelim} width: {$admin_left_size|wash}; {rdelim}
        div#page div#maincontent {ldelim} margin-left: {$admin_left_size|wash}; {rdelim}
    {/if}
    {undef $left_menu_widths}
{/if}
</style>
{/if}

{* Pr uri header cache *}
{cache-block keys=array( $module_result.uri, $user_hash, $admin_theme ) ignore_content_expiry}

{include uri='design:page_head.tpl'}

{include uri='design:page_head_style.tpl'}
{include uri='design:page_head_script.tpl'}

{* Pr tab header cache *}
{cache-block keys=array( $navigation_part.identifier, $module_result.navigation_part, $ui_context, $ui_component, $user_hash ) ignore_content_expiry}

</head>
<body>

<div id="page" class="{$navigation_part.identifier} section_id_{first_set( $module_result.section_id, 0 )}">

<div id="header">
<div id="header-design" class="float-break">

    {* HEADER ( SEARCH, LOGO AND USERMENU ) *}
    {include uri='design:page_header.tpl'}

    {* TOP MENU / TABS *}
    {include uri='design:page_topmenu.tpl'}

</div>
</div>
{/cache-block}{* /Pr tab cache *}

<hr class="hide" />
{/cache-block}{* /Pr uri cache *}

<div id="columns"{if $hide_right_menu} class="hide-rightmenu"{/if}>

{* RIGHT MENU *}
<div id="rightmenu">
{if or( $hide_right_menu, $collapse_right_menu )}
    <a id="rightmenu-showhide" class="show-hide-control" title="{'Show / Hide rightmenu'|i18n( 'design/admin/pagelayout/rightmenu' )}" href={'/user/preferences/set/admin_right_menu_show/1'|ezurl}>&laquo;</a>
    <div id="rightmenu-design"></div>
{else}
    <a id="rightmenu-showhide" class="show-hide-control" title="{'Hide / Show rightmenu'|i18n( 'design/admin/pagelayout/rightmenu' )}" href={'/user/preferences/set/admin_right_menu_show/0'|ezurl}>&raquo;</a>
        <div id="rightmenu-design">
            {tool_bar name='admin_right' view='full'}
            {tool_bar name='admin_developer' view='full'}
        </div>
    <!-- script type="text/javascript" src={"javascript/rightmenu_widthcontrol.js"|ezdesign} charset="utf-8"></script -->
    <script type="text/javascript">
        rightMenuWidthControl();
    </script>
{/if}
</div>


<div id="maincolumn">

{* Pr uri Path/Left menu cache (dosn't use ignore_content_expiry because of content structure menu  ) *}
{cache-block keys=array( $module_result.uri, $user_hash, $left_size_hash )}

<div id="path">
<div id="path-design">
    {include uri='design:page_toppath.tpl'}
</div>
</div>

<hr class="hide" />

{* LEFT MENU / CONTENT STRUCTURE MENU *}
{if $content_edit}
{else}
    {include uri='design:page_leftmenu.tpl'}
{/if}

{/cache-block}{* /Pr uri cache *}

{* Main area START *}
{if $content_edit}
    {include uri='design:page_mainarea.tpl'}
{else}
    <div id="maincontent">
    <div id="maincontent-design" class="float-break"><div id="fix">
    <!-- Maincontent START -->
    {include uri='design:page_mainarea.tpl'}
    <!-- Maincontent END -->
    </div>
    <div class="break"></div>
    </div></div>
{/if}
{* Main area END *}
</div>


<div class="break"></div>
</div><!-- div id="columns" -->

<hr class="hide" />


{cache-block ignore_content_expiry}
<div id="footer" class="float-break">
<div id="footer-design">
    {include uri='design:page_copyright.tpl'}
</div>
</div>

<div class="break"></div>

{* The popup menu include must be outside all divs. It is hidden by default. *}
{include uri='design:popupmenu/popup_menu.tpl'}

{/cache-block}

<script type="text/javascript">
<!--

document.getElementById('header-usermenu-logout').innerHTML += '<span class="header-usermenu-name">{$current_user.login|wash}<\/span>';

{literal}
(function( $ )
{
    var searchtext = document.getElementById('searchtext');
    if ( searchtext && !searchtext.disabled )
    {
        jQuery( searchtext ).val( searchtext.title
        ).addClass('passive'
        ).focus(function(){
                if ( this.value === this.title )
                {
                    jQuery( this ).removeClass('passive').val('');
                }
        }).blur(function(){
            if ( this.value === '' )
            {
                jQuery( this ).addClass('passive').val( this.title );
            }
        });
        
    }
})( jQuery );
{/literal}

// -->
</script>

{* This comment will be replaced with actual debug report (if debug is on). *}
<!--DEBUG_REPORT-->
</div><!-- div id="page" -->

</body>
</html>

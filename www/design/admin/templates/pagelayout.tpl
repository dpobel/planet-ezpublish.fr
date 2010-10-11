<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$site.http_equiv.Content-language|wash}" lang="{$site.http_equiv.Content-language|wash}">

<head>
{include uri='design:page_head.tpl'}

{set-block variable=$admin_right_menu}
{tool_bar name='admin_right' view=full}
{tool_bar name='admin_developer' view=full}
{/set-block}


{def $hide_right_menu = $admin_right_menu|eq('')
     $admin_left_width = ezpreference( 'admin_left_menu_width' )}

{* cache-block keys=array($navigation_part.identifier, $current_user.role_id_list|implode( ',' ), $current_user.limited_assignment_value_list|implode( ',' ), $ui_context, $hide_right_menu, $admin_left_width) *}
{* Cache header for each navigation part *}

{include uri='design:page_head_style.tpl'}
{include uri='design:page_head_script.tpl'}


</head>

<body>

<div id="allcontent">
<div id="header">
<div id="header-design">

<div id="logo">
<img src={'ezpublish-logo-4-symbol.gif'|ezimage} width="256" height="40" alt="eZ Publish" border="0" />
<p>version {fetch( setup, version )}</p>
</div>

{* --- Search ---*}
<div id="search">
<form action={'/content/search/'|ezurl} method="get">

{if eq( $ui_context, 'edit' )}
    <input id="searchtext" name="SearchText" type="text" size="20" value="{if is_set( $search_text )}{$search_text|wash}{/if}" disabled="disabled" />
    <input id="searchbutton" class="button-disabled" name="SearchButton" type="submit" value="{'Search'|i18n( 'design/admin/pagelayout' )}" disabled="disabled" />
{else}
    <input id="searchtext" name="SearchText" type="text" size="20" value="{if is_set( $search_text )}{$search_text|wash}{/if}" />
    <input id="searchbutton" class="button" name="SearchButton" type="submit" value="{'Search'|i18n( 'design/admin/pagelayout' )}" />
    {if eq( $ui_context, 'browse' ) }
        <input name="Mode" type="hidden" value="browse" />
        <input name="BrowsePageLimit" type="hidden" value="{min( ezpreference( 'admin_list_limit' ), 3)|choose( 10, 10, 25, 50 )}" />
    {/if}
{/if}
    <p class="select">
    {let disabled=false()
         nd=1
         left_checked=true()
         current_loc=true()}
    {if eq( $ui_context, 'edit' )}
        {set disabled=true()}
    {else}
        {if is_set($module_result.node_id)}
            {set nd=$module_result.node_id}
        {else}
            {if is_set($search_subtree_array)}
                {if count($search_subtree_array)|eq(1)}
                    {if $search_subtree_array.0|ne(1)}
                        {set nd=$search_subtree_array.0}
                        {set left_checked=false()}
                    {else}
                        {set disabled=true()}
                    {/if}
                    {set current_loc=false()}
                {else}
                    {set disabled=true()}
                {/if}
            {else}
                {set disabled=true()}
            {/if}
        {/if}
    {/if}
    <label{if $disabled} class="disabled"{/if}><input type="radio" name="SubTreeArray" value="1" checked="checked"{if $disabled} disabled="disabled"{else} title="{'Search all content.'|i18n( 'design/admin/pagelayout' )}"{/if} />{'All content'|i18n( 'design/admin/pagelayout' )}</label>
    <label{if $disabled} class="disabled"{/if}><input type="radio" name="SubTreeArray" value="{$nd}"{if $disabled} disabled="disabled"{else} title="{'Search only from the current location.'|i18n( 'design/admin/pagelayout' )}"{/if} />{if $current_loc}{'Current location'|i18n( 'design/admin/pagelayout' )}{else}{'The same location'|i18n( 'design/admin/pagelayout' )}{/if}</label>
    {/let}
    </p>
    <p class="advanced">
    {if or( eq( $ui_context, 'edit' ), eq( $ui_context, 'browse' ) )}
    <span class="disabled">{'Advanced'|i18n( 'design/admin/pagelayout' )}</span>
    {else}
        <a href={'/content/advancedsearch'|ezurl} title="{'Advanced search.'|i18n( 'design/admin/pagelayout' )}">{'Advanced'|i18n( 'design/admin/pagelayout' )}</a>
    {/if}
    </p>
</form>
</div>

<div class="break"></div>

</div>
</div>

<hr class="hide" />

<div id="topmenu">
<div id="topmenu-design">

<h3 class="hide">Top menu</h3>
<ul>
{section var=Menu loop=topmenu($ui_context)}

    {include uri='design:page_topmenuitem.tpl' menu_item=$Menu navigationpart_identifier=$navigation_part.identifier}

{/section}

{if $hide_right_menu}
<li class="last"><div>
<a href={'/user/logout'|ezurl} title="{'Logout from the system.'|i18n( 'design/admin/pagelayout' )}">{'Logout'|i18n( 'design/admin/pagelayout' )}</a>
</div></li>
{/if}

</ul>
<div class="break"></div>
</div>
</div>

{* /cache-block *}

<hr class="hide" />


<div id="path">
<div id="path-design">

{include uri='design:page_toppath.tpl'}

</div>
</div>


<hr class="hide" />

<div id="columns">

{if and( eq( $ui_context, 'edit' ), eq( $ui_component, 'content' ) )}
{else}
<div id="leftmenu">
<div id="leftmenu-design">

{if is_set( $module_result.left_menu )}
    {include uri=$module_result.left_menu}
{else}
	{* 
	    Get navigationpart identifier variable depends if the call is an contenobject
	    or a custom module 
	*}
	{def $navigation_part_name = $navigation_part.identifier}
	{if $navigation_part_name|eq('')}
	    {set $navigation_part_name = $module_result.navigation_part}
	{/if}
	
	{* 
	    Include automatically the menu template for the $navigation_part_name
	    ez $part_name navigationpart =>  parts/$part_name/menu.tpl
	*}
	{def $extract_length = sub( count_chars( $navigation_part_name ), '14' )
	     $part_name = $navigation_part_name|extract( '2', $extract_length )}
	
	{include uri=concat( 'design:parts/', $part_name, '/menu.tpl' )}
	
	{undef $extract_length $part_name $navigation_part_name}
{/if}

</div>
</div>

<hr class="hide" />

{/if}

<div id="rightmenu">
<div id="rightmenu-design">

<h3 class="hide">Right</h3>

{$admin_right_menu}

</div>
</div>

<hr class="hide" />

{if and( eq( $ui_context, 'edit' ), eq( $ui_component, 'content' ) )}

{* Main area START *}

{include uri='design:page_mainarea.tpl'}

{* Main area END *}

{else}

<div id="maincontent"><div id="fix">
<div id="maincontent-design">

<!-- Maincontent START -->
{* Main area START *}

{include uri='design:page_mainarea.tpl'}

{* Main area END *}

<!-- Maincontent END -->
</div>
<div class="break"></div>
</div></div>

{/if}

<div class="break"></div>
</div>

<hr class="hide" />

<div id="footer">
<div id="footer-design">

{include uri='design:page_copyright.tpl'}

</div>
</div>

<div class="break"></div>
</div>

{* The popup menu include must be outside all divs. It is hidden by default. *}
{include uri='design:popupmenu/popup_menu.tpl'}

{* This comment will be replaced with actual debug report (if debug is on). *}
<!--DEBUG_REPORT-->

</body>
</html>

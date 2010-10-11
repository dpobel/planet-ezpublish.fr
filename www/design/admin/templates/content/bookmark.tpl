{let bookmark_list=fetch( content, bookmarks, array() )}
<form name="bookmarkaction" action={concat( 'content/bookmark/' )|ezurl} method="post" >

<div class="context-block">
{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h1 class="context-title">{'My bookmarks [%bookmark_count]'|i18n( 'design/admin/content/bookmark',, hash( '%bookmark_count', $bookmark_list|count ) )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{section show=$bookmark_list}
<table class="list" cellspacing="0">
<tr>
    <th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/content/bookmark' )}" onclick="ezjs_toggleCheckboxes( document.bookmarkaction, 'DeleteIDArray[]' ); return false;" title="{'Invert selection.'|i18n( 'design/admin/content/bookmark' )}" /></th>
    <th>{'Name'|i18n( 'design/admin/content/bookmark' )}</th>
    <th>{'Type'|i18n( 'design/admin/content/bookmark' )}</th>
    <th>{'Section'|i18n( 'design/admin/content/bookmark' )}</th>
    <th class="tight">&nbsp;</th>
</tr>

{section var=Bookmarks loop=$bookmark_list sequence=array( bglight, bgdark )}
<tr class="{$Bookmarks.sequence}">
    <td><input type="checkbox" name="DeleteIDArray[]" value="{$Bookmarks.item.id}" title="{'Select bookmark for removal.'|i18n( 'design/admin/content/bookmark' )}" /></td>
    <td>{$Bookmarks.item.node.object.content_class.identifier|class_icon( small, $Bookmarks.item.node.object.content_class.name )}&nbsp;<a href={concat( '/content/view/full/', $Bookmarks.item.node_id, '/' )|ezurl}>{$Bookmarks.item.node.name|wash}</a></td>
    <td>{$Bookmarks.item.node.object.content_class.name|wash}</td>
    <td>{let section_object=fetch( section, object, hash( section_id, $Bookmarks.item.node.object.section_id ) )}{section show=$section_object}{$section_object.name|wash}{section-else}<i>{'Unknown'|i18n( 'design/admin/content/bookmark' )}</i>{/section}{/let}</td>
    <td>
    {if $Bookmarks.item.node.object.can_edit}
        <a href={concat( 'content/edit/', $Bookmarks.item.node.contentobject_id )|ezurl}><img src={'edit.gif'|ezimage} alt="{'Edit'|i18n( 'design/admin/content/bookmark' )}" title="{'Edit <%bookmark_name>.'|i18n( 'design/admin/content/bookmark',, hash( '%bookmark_name', $Bookmarks.item.node.name ) )|wash}" /></a>
    {else}
        <img src={'edit-disabled.gif'|ezimage} alt="{'Edit'|i18n( 'design/admin/content/bookmark' )}" title="{'You do not have permission to edit the contents of <%bookmark_name>.'|i18n( 'design/admin/content/bookmark',, hash( '%bookmark_name', $Bookmarks.item.node.name ) )|wash}" />
    {/if}
    </td>
</tr>
{/section}
</table>

{*
<div class="context-toolbar">
{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri='/content/draft'
         item_count=$list_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>
*}

{section-else}
<div class="block">
<p>{'There are no bookmarks in the list.'|i18n( 'design/admin/content/bookmark' )}</p>
</div>
{/section}


{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">

{if $bookmark_list}
<input class="button" type="submit" name="RemoveButton" value="{'Remove selected'|i18n( 'design/admin/content/bookmark' )}" title="{'Remove selected bookmarks.'|i18n( 'design/admin/content/bookmark' )}" />
{else}
<input class="button-disabled" type="submit" name="RemoveButton" value="{'Remove selected'|i18n( 'design/admin/content/bookmark' )}" disabled="disabled" />
{/if}

<input class="button" type="submit" name="AddButton" value="{'Add items'|i18n( 'design/admin/content/bookmark' )}" title="{'Add items to your personal bookmark list.'|i18n( 'design/admin/content/bookmark' )}" />
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>

{/let}

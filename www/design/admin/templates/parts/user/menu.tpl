{section show=eq( $ui_context, 'edit' )}
{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Role information'|i18n( 'design/admin/parts/user/menu' )}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<p>
<label>{'Name'|i18n( 'design/admin/parts/user/menu' )}:</label>
{$role.name|wash}
</p>

<p>
<label>{'ID'|i18n( 'design/admin/parts/user/menu' )}:</label>
{$role.id|wash}
</p>

{* DESIGN: Content END *}</div></div></div></div></div></div>

{section-else}

<div id="content-tree">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

{section show=ezpreference( 'admin_treemenu' )}
<h4><a class="showhide" href={'/user/preferences/set/admin_treemenu/0'|ezurl} title="Hide users and user groups."><span class="bracket">[</span>-<span class="bracket">]</span></a> {'User accounts'|i18n( 'design/admin/parts/user/menu' )}</h4>
{section-else}
<h4><a class="showhide" href={'/user/preferences/set/admin_treemenu/1'|ezurl} title="Show users and user groups."><span class="bracket">[</span>+<span class="bracket">]</span></a> {'User accounts'|i18n( 'design/admin/parts/user/menu' )}</h4>
{/section}

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

{* Treemenu. *}
<div id="contentstructure">
{section show=ezpreference( 'admin_treemenu' )}
    {if ezini('TreeMenu','Dynamic','contentstructuremenu.ini')|eq('enabled')}
        {include uri='design:contentstructuremenu/content_structure_menu_dynamic.tpl' custom_root_node_id=ezini( 'NodeSettings', 'UserRootNode', 'content.ini')}
    {else}
        {include uri='design:contentstructuremenu/content_structure_menu.tpl' custom_root_node_id=ezini( 'NodeSettings', 'UserRootNode', 'content.ini')}
    {/if}
{/section}
</div>

{* Roles & policies + trashcan. *}
{section show=ne( $ui_context, 'browse')}
<div id="trash">
<ul>
    <li><img src={'trash-icon-16x16.gif'|ezimage} width="16" height="16" alt="Trash" />&nbsp;<a href={concat( '/content/trash/', ezini( 'NodeSettings', 'RootNode', 'content.ini' ) )|ezurl} title="{'View and manage the contents of the trash bin.'|i18n( 'design/admin/parts/user/menu' )}">{'Trash'|i18n( 'design/admin/parts/user/menu' )}</a></li>
</ul>
</div>
{/section}

{* Left menu width control. *}
<div class="widthcontrol">
<p>
{switch match=ezpreference( 'admin_left_menu_width' )}
{case match='medium'}
<a href={'/user/preferences/set/admin_left_menu_width/small'|ezurl} title="{'Change the left menu width to small size.'|i18n( 'design/admin/parts/user/menu' )}">{'Small'|i18n( 'design/admin/parts/user/menu' )}</a>
<span class="current">{'Medium'|i18n( 'design/admin/parts/user/menu' )}</span>
<a href={'/user/preferences/set/admin_left_menu_width/large'|ezurl} title="{'Change the left menu width to large size.'|i18n( 'design/admin/parts/user/menu' )}">{'Large'|i18n( 'design/admin/parts/user/menu' )}</a>
{/case}

{case match='large'}
<a href={'/user/preferences/set/admin_left_menu_width/small'|ezurl} title="{'Change the left menu width to small size.'|i18n( 'design/admin/parts/user/menu' )}">{'Small'|i18n( 'design/admin/parts/user/menu' )}</a>
<a href={'/user/preferences/set/admin_left_menu_width/medium'|ezurl} title="{'Change the left menu width to medium size.'|i18n( 'design/admin/parts/user/menu' )}">{'Medium'|i18n( 'design/admin/parts/user/menu' )}</a>
<span class="current">{'Large'|i18n( 'design/admin/parts/user/menu' )}</span>
{/case}

{case}
<span class="current">{'Small'|i18n( 'design/admin/parts/user/menu' )}</span>
<a href={'/user/preferences/set/admin_left_menu_width/medium'|ezurl} title="{'Change the left menu width to medium size.'|i18n( 'design/admin/parts/user/menu' )}">{'Medium'|i18n( 'design/admin/parts/user/menu' )}</a>
<a href={'/user/preferences/set/admin_left_menu_width/large'|ezurl} title="{'Change the left menu width to large size.'|i18n( 'design/admin/parts/user/menu' )}">{'Large'|i18n( 'design/admin/parts/user/menu' )}</a>
{/case}
{/switch}
</p>
</div>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>

{* Roles & policies + trashcan. *}
{section show=ne( $ui_context, 'browse')}

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Access control'|i18n( 'design/admin/parts/user/menu' )}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<ul>
    <li><a href={'role/list/'|ezurl} title="{'Manage permission settings.'|i18n( 'design/admin/parts/user/menu' )}">{'Roles and policies'|i18n( 'design/admin/parts/user/menu' )}</a></li>
</ul>

{* DESIGN: Content END *}</div></div></div></div></div></div>

{/section}

{/section}

{*
 * $Id: list.tpl 19 2011-06-22 20:04:04Z dpobel $
 * $HeadURL: http://svn.projects.ez.no/ezclasslists/tags/ezclasslists_1_2/ezclasslists/design/standard/templates/classlists/list.tpl $
 *}
{def
    $item_type = ezpreference( 'admin_classlists_limit' )
    $limit = min( $item_type, 3 )|choose( 10, 10, 25, 50 )
    $filter_hash = hash( 'parent_node_id', 1,
                         'main_node_only', true(),
                         'sort_by', array( $sort_method, $sort_order ),
                         'limit', $limit,
                         'offset', $view_parameters.offset )
     $filter_count_hash = hash( 'parent_node_id', 1,
                                'main_node_only', true() )
     $nodes_count = 0
     $nodes_list = array()
     $confirm_js = ezini( 'DeleteSettings', 'ConfirmJavascript', 'lists.ini' )
     $move_to_trash = ezini( 'DeleteSettings', 'DefaultMoveToTrash', 'lists.ini' )
}

{if $class_identifier}
    {set $filter_count_hash = hash( 'parent_node_id', 1,
                                    'main_node_only', true(),
                                    'class_filter_type', include,
                                    'class_filter_array', array( $class_identifier ) )}
    {set $filter_hash = hash( 'parent_node_id', 1,
                              'sort_by', array( $sort_method, $sort_order ),
                              'class_filter_type', include,
                              'class_filter_array', array( $class_identifier ),
                              'main_node_only', true(),
                              'limit', $limit,
                              'offset', $view_parameters.offset )}
{/if}
{debug-log msg='template fetch filter' var=$filter_hash}
{set $nodes_count = fetch( content, tree_count, $filter_count_hash )}
{set $nodes_list  = fetch( content, tree, $filter_hash )}
{if is_set( $remove_count )}
    <div class="message-feedback">
        <h2>{'%remove_count objects deleted'|i18n( 'classlists/list', , hash( '%remove_count', $remove_count ) )}</h2>
    </div>
{/if}
{if is_set( $error )}
    <div class="message-warning">
        <h2>{$error|wash()}</h2>
    </div>
{/if}
<div class="context-block">
<form name="classlists" action={$page_uri|ezurl()} method="post"{if $confirm_js|eq( 'enabled' )} onsubmit="return confirm('{'Are you sure you want to delete these objects ?'|i18n('classlists/list')|wash( 'javascript' )}');"{/if}>


<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h1 class="context-title">{'%count objects'|i18n( 'classlists/list', , hash( '%count', $nodes_count ) )}</h1>
<div class="header-subline"></div>
</div></div></div></div></div></div>

<div class="box-ml"><div class="box-mr"><div class="box-content">

<div class="context-toolbar">
<div class="button-left">
<p class="table-preferences">
    {switch match=$limit}
    {case match=25}
        <a href={concat( '/user/preferences/set/admin_classlists_limit/1/', $page_uri )|ezurl} title="{'Show 10 items per page.'|i18n( 'design/admin/node/view/full' )}">10</a>
        <span class="current">25</span>
        <a href={concat( '/user/preferences/set/admin_classlists_limit/3/', $page_uri )|ezurl} title="{'Show 50 items per page.'|i18n( 'design/admin/node/view/full' )}">50</a>
    {/case}

    {case match=50}
        <a href={concat( '/user/preferences/set/admin_classlists_limit/1/', $page_uri )|ezurl} title="{'Show 10 items per page.'|i18n( 'design/admin/node/view/full' )}">10</a>
        <a href={concat( '/user/preferences/set/admin_classlists_limit/2/', $page_uri )|ezurl} title="{'Show 25 items per page.'|i18n( 'design/admin/node/view/full' )}">25</a>
        <span class="current">50</span>
    {/case}

    {case}
        <span class="current">10</span>
        <a href={concat( '/user/preferences/set/admin_classlists_limit/2/', $page_uri )|ezurl} title="{'Show 25 items per page.'|i18n( 'design/admin/node/view/full' )}">25</a>
        <a href={concat( '/user/preferences/set/admin_classlists_limit/3/', $page_uri )|ezurl} title="{'Show 50 items per page.'|i18n( 'design/admin/node/view/full' )}">50</a>
    {/case}

    {/switch}
</p>
</div>
<div class="break"></div>

</div>


<div class="content-navigation-childlist">
<table class="list" cellspacing="0">
<tbody>
<tr>
    <th class="remove"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.classlists, 'DeleteIDArray[]' ); return false;" /></th>
    <th class="name">{'Name'|i18n( 'design/admin/node/view/full' )}</th>
    <th class="class">{'Type'|i18n( 'design/admin/node/view/full' )}</th>
    <th class="modified">{'Modified'|i18n( 'design/admin/node/view/full' )}</th>
    <th class="edit">&nbsp;</th>
</tr>


{foreach $nodes_list as $k => $node sequence array( 'bgdark', 'bglight' ) as $style}
<tr class="{$style}">
<td>
    <input name="DeleteIDArray[]" value="{$node.node_id}" type="checkbox"{if $node.can_remove|not()} disabled="disabled"{/if} />
</td>
<td>
    <a href={$node.url_alias|ezurl()}>{$node.name|wash()}</a>
</td>
<td class="class">
    <a href={concat( 'classlists/list/', $node.class_identifier )|ezurl()}>{$node.class_name|wash()}</a>
</td>
<td class="modified">
    {$node.object.modified|l10n(datetime)}
</td>
<td class="edit">
    <a href={concat( '/content/edit/', $node.object.id )|ezurl()}><img src={'edit.gif'|ezimage()} alt="{'Modify'|i18n( 'classlists/list')}" /></a>
</td>
</tr>
{/foreach}
</tbody></table>
</div>
<div class="context-toolbar">
{include name=navigator uri='design:navigator/google.tpl'
                        page_uri=$page_uri
                        item_count=$nodes_count
                        view_parameters=$view_parameters
                        item_limit=$limit}
        </div>
</div></div></div>



<div class="controlbar">
    <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
        <div class="left">
            <p>
            <label for="MoveToTrash">{'Move to trash'|i18n( 'classlists/list' )}</label>
            <input type="checkbox" value="1" name="MoveToTrash" id="MoveToTrash"{if $move_to_trash|eq( 'enabled' )} checked="checked"{/if} />
            </p>
            <input class="button" type="submit" name="RemoveButton" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" title="{'Remove the selected items from the list above.'|i18n( 'design/admin/node/view/full' )}" />
        </div>
        <div class="right">

        </div>
        <div class="break"></div>
    </div>
    </div></div></div></div></div></div>
</div>

</form>
</div>

{undef $filter_hash $filter_count_hash $nodes_count $nodes_list $confirm_js $move_to_trash}

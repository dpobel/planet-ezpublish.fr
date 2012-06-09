{ezscript_require( 'ezjsc::jquery', 'ezjsc:jqueryio' )}
<script type="text/javascript">
{literal}
$(document).ready(function() {
    $('.retry-button input').live( 'click', function(evt) {
        var eventID = $(this).attr('name').replace('Retry_', '');
        var tr = $('#event_' + eventID);
        var cellsCount = tr.children('td').length;
        var url = 'autostatus::retry::' + eventID;
        tr.removeClass('exception');
        tr.removeClass('error');
        tr.html('<td class="waiting" colspan="' + cellsCount + '"></td>');
        $.ez(url, false, function(data) {
            tr.html(data.content.html);
            tr.addClass(data.content.class);
        });
        evt.preventDefault();
    });
});
{/literal}
</script>
<div class="context-block">

<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
{if $display_type|eq( 'succeed' )}
    <h1 class="context-title">{'%count successful events (Total %count_total)'|i18n( 'autostatus/log', , hash( '%count', $events_count, '%count_total', $total_count ) )}</h1>
{elseif $display_type|eq( 'error' )}
    <h1 class="context-title">{'%count error events (Total %count_total)'|i18n( 'autostatus/log', , hash( '%count', $events_count, '%count_total', $total_count ) )}</h1>
{else}
    <h1 class="context-title">{'%count events'|i18n( 'autostatus/log', , hash( '%count', $events_count ) )}</h1>
{/if}
<div class="header-subline"></div>
</div></div></div></div></div></div>

<div class="box-ml"><div class="box-mr"><div class="box-content">

{if $events_count|eq( 0 )}
    <div class="message-feedback">
        <h2>{'No update status event'|i18n( 'autostatus/log' )}</h2>
    </div>
{else}
<div class="content-navigation-childlist">
<table class="list" cellspacing="0">
<tbody>
<tr>
    <th>{'Social network'|i18n( 'autostatus/log' )}</th>
    <th>{'Status message'|i18n( 'autostatus/log' )}</th>
    <th>{'Content'|i18n( 'autostatus/log' )}</th>
    <th>{'Author'|i18n( 'autostatus/log' )}</td>
    <th class="modified">{'Created'|i18n( 'autostatus/log' )}</th>
    <th class="modified">{'Modified'|i18n( 'autostatus/log' )}</th>
    <th>{'Error message'|i18n( 'autostatus/log' )}</th>
    <th class="edit">&nbsp;</th>
</tr>
{foreach $events as $event sequence array( 'bgdark', 'bglight' ) as $style}
    <tr class="{$style} {$event.status_text}" id="event_{$event.id}">
    {include uri="design:autostatus/event.tpl" event=$event}
    </tr>
{/foreach}
</tbody>
</table>

<div class="context-toolbar">
{include name=navigator uri='design:navigator/google.tpl'
                        page_uri=$page_uri
                        item_count=$events_count
                        view_parameters=hash( 'offset', $offset )
                        item_limit=$limit}
</div><!-- context-toolbar -->
</div>
{/if}

</div></div></div>

</div><!-- context-block -->

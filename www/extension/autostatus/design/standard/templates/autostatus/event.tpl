{def $author = $event.user
     $content = $event.object}
<td>{if $event.event.login|ne( '' )}{$event.event.login|wash}@{/if}{$event.event.social_network.name|wash}</td>
<td>{$event.message|wash|autolink}</td>
{if $content|is_object}
<td><a href={$content.main_node.url_alias|ezurl}>{$content.name|wash}</a></td>
{else}
<td>?</td>
{/if}
{if $author|is_object}
<td><a href={$author.contentobject.main_node.url_alias|ezurl}>{$author.contentobject.name|wash}</a></td>
{else}
<td>?</td>
{/if}
<td>{$event.created|l10n( 'shortdatetime' )}</td>
<td>{$event.modified|l10n( 'shortdatetime' )}</td>
<td class="message">{cond( and( $event.is_error, $event.error_msg|eq( '' ) ), '?', $event.error_msg|wash )}</td>
<td class="retry-button">
{if $event.is_error}
    <input type="submit" class="button{cond( $event.event|is_object, '', ' button-disabled' )}" name="Retry_{$event.id}" value="{'Retry'|i18n( 'autostatus/log' )}"{cond( $event.event|is_object, '', ' disabled="disabled"' )} />
{else}
    <input type="submit" class="button{cond( $event.event|is_object, '', ' button-disabled' )}" name="Retry_{$event.id}" value="{'Send again'|i18n( 'autostatus/log' )}"{cond( $event.event|is_object, '', ' disabled="disabled"' )} />
{/if}
</td>

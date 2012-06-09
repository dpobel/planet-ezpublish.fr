{if $network.require_oauth}
<p>
    {if and( is_object( $event.access_token ), $event.access_token_network_identifier|eq( $network.identifier ) )}
        {if $event.login|eq( '' )}
            {'Your access has already been granted on %network.'|i18n( 'design/admin/workflow/eventtype/edit', '', hash( '%network', $network.name ) )}
        {else}
            {'Your access has already been granted on %network with account <strong>%login</strong>.'|i18n( 'design/admin/workflow/eventtype/edit', '', hash( '%login', $event.login, '%network', $network.name ) )}
        {/if}
        <input type="submit" value="{'Manage OAuth access'|i18n( 'design/admin/workflow/eventtype/edit' )}" name="CustomActionButton[{$event.id}_OAuthCheck]" class="button" />
    {else}
        {'Please click on the following button to go on %network and authorize autostatus to update your status on your behalf.'|i18n( 'design/admin/workflow/eventtype/edit', '', hash( '%network', $network.name ) )}
        <input type="submit" value="{'Authorize autostatus'|i18n( 'design/admin/workflow/eventtype/edit' )}" name="CustomActionButton[{$event.id}_OAuthCheck]" class="button defaultbutton" />
    {/if}
</p>
{else}
<p>
    <label class="radio" for="Login_{$event.id}">{'Login'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
    <input type="text" name="Login_{$event.id}" id="Login_{$event.id}" value="{$event.login|wash}" size="20" />
    &nbsp;&nbsp;&nbsp;
    <label class="radio" for="Password_{$event.id}">{'Password'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
    <input type="password" name="Password_{$event.id}" id="Password_{$event.id}" value="" size="20" />
</p>
{/if}

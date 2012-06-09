{def $class = $event.class
     $attribute = $event.attribute
     $triggerAttribute = $event.trigger_attribute 
     $network = $event.social_network
     $login = $event.login
     $access_token = $event.access_token}
<div class="element">
    <ul>
        <li><strong>{'Content class'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {$class.name|wash}</li>
        <li><strong>{'Attribute used for status'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {$attribute.name|wash}</li>
        <li><strong>{'Attribute used for triggering the update'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {if $triggerAttribute}{$triggerAttribute.name|wash}{else}<em>{'No attribute dependency, sending every time'|i18n( 'design/admin/workflow/eventtype/edit' )}</em>{/if}</li>        
        <li>
            <strong>{'Social network'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {$login|wash}@{$network.name|wash}
            {if and( $network.require_oauth, $access_token|is_object() )}
            ({'OAuth access OK'|i18n( 'design/admin/workflow/eventtype/edit' )})
            {else}
            ({'OAuth access KO'|i18n( 'design/admin/workflow/eventtype/edit' )})
            {/if}
        </li>
        <li><strong>{'Defer status update to cronjob'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {cond( $event.use_cronjob, 'Yes'|i18n( 'design/admin/workflow/eventtype/edit' ), 'No'|i18n( 'design/admin/workflow/eventtype/edit' ) )}</li>
        <li><strong>{'Siteaccess to generate URLs for'|i18n( 'design/admin/workflow/eventtype/edit' )}</strong> : {if eq( $event.siteaccess, -1 )}<em>{'The current one'|i18n( 'design/admin/workflow/eventtype/edit' )}</em>{else}{$event.siteaccess}{/if}</li>        
    </ul>
</div>
{undef $class $attribute $network $login}

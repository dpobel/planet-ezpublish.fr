{ezscript_require( 'ezjsc::jquery', 'ezjsc:jqueryio' )}
{def $classes=fetch( 'class', 'list', hash( 'sort_by', array( 'name', true() ) ) )
     $attributes = array()
     $social_networks = fetch( autostatus, network_list )
     $selected_social_network = false
     $allowed_datatypes = ezini( 'AutoStatusSettings', 'StatusDatatype', 'autostatus.ini',, true() )
     $allowed_datatypes_for_trigger = ezini( 'AutoStatusSettings', 'StatusTriggerDatatype', 'autostatus.ini',, true() )}
<script type="text/javascript">
<!--
(function() {ldelim}

    var classIdentifierAttributesArray = [];
    var classIdentifierAttributesArrayForTrigger = [];
    {foreach $classes as $class}
        {set $attributes = fetch( 'class', 'attribute_list', hash( 'class_id', $class.id ) )}

    classIdentifierAttributesArray["{$class.identifier}"] = [];
    classIdentifierAttributesArrayForTrigger["{$class.identifier}"] = [];
        {foreach $attributes as $attribute}
            {if $allowed_datatypes|contains( $attribute.data_type_string )}

    classIdentifierAttributesArray["{$class.identifier}"].push({ldelim}

        identifier: "{$attribute.identifier}",
        datatype: "{$attribute.data_type_string}",
        name: "{$attribute.name|wash( 'javascript' )}"
    {rdelim});{/if}
            {if $allowed_datatypes_for_trigger|contains( $attribute.data_type_string )}

    classIdentifierAttributesArrayForTrigger["{$class.identifier}"].push({ldelim}

        identifier: "{$attribute.identifier}",
        datatype: "{$attribute.data_type_string}",
        name: "{$attribute.name|wash( 'javascript' )}"
    {rdelim});{/if}
        {/foreach}
    {/foreach}

    var eventID = {$event.id};
    var selectAttrIDs = ['#AttributeIdentifier_' + eventID, '#AttributeIdentifierTrigger_' + eventID];
    var attributesArray = [classIdentifierAttributesArray, classIdentifierAttributesArrayForTrigger];
    var noAttributeMsg = ['{'No suitable attribute in the selected content class'|i18n( 'design/admin/workflow/eventtype/edit' )|wash( 'javascript' )}',
                          '{'Send every time'|i18n( 'design/admin/workflow/eventtype/edit' )|wash( 'javascript' )}'];
    var noAttributeValue = ['', -1];
    var alwaysDisplayNoAttributeOption = [false, true];

    {literal}
    $(document).ready(function() {
        $('#SocialNetwork_' + eventID).change(function() {
            var url = 'autostatus::auth::' + $(this).val() + '::' + eventID;
            var p = $('#auth_' + eventID);
            if ( $(this).val() === '' ) {
                p.html('');
                return;
            }
            p.html('');
            p.addClass('waiting');
            $.ez(url, false, function(data) {
                p.removeClass('waiting')
                p.html(data.content);
            });
        });
        $('#SocialNetwork_' + eventID).change();

        $('#ClassIdentifier_' + eventID).change(function() {
            // TODO support optgroup
            for ( var j=0; j < selectAttrIDs.length; j++ ) {
                var attributeSelect = $(selectAttrIDs[j]);
                var classIdentifier = $(this).val();
                var attributes = attributesArray[j][classIdentifier];
                if ( !attributes || attributes.length == 0 ) {
                    attributeSelect.html('<option value="' + noAttributeValue[j] + '">' + noAttributeMsg[j] + '</option>');
                    attributeSelect.attr('disabled', 'disabled');
                } else {
                    attributeSelect.html('<option value=""></option>');
                    if ( alwaysDisplayNoAttributeOption[j] ) {
                        attributeSelect.append('<option value="' + noAttributeValue[j] + '">' + noAttributeMsg[j] + '</option>');
                    }
                    attributeSelect.attr('disabled', '');
                    for( var i=0; i!=attributes.length; i++) {
                        attributeSelect.append('<option value="' + attributes[i]['identifier'] + '">' + attributes[i]['name'] + ' (' + attributes[i]['datatype'] + ')</option>');
                    }
                }
            }
        });
        {/literal}

    {rdelim});

{rdelim})();
-->
</script>
<div class="block">
    <fieldset>
        <legend>{'Account informations'|i18n( 'design/admin/workflow/eventtype/edit' )}</legend>
        <p>
            <label class="radio" for="SocialNetwork_{$event.id}">{'Social network'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <select id="SocialNetwork_{$event.id}" name="SocialNetwork_{$event.id}">
                <option value="">{'Choose a social network'|i18n( 'design/admin/workflow/eventtype/edit' )}</option>
            {foreach $social_networks as $network}
                <option value="{$network.identifier}"{if $event.social_network_identifier|eq( $network.identifier )}{set $selected_social_network = $network} selected="selected"{/if}>{$network.name|wash()}</option>
            {/foreach}
            </select>
        </p>
        <p id="auth_{$event.id}" class="auth"></p>
    </fieldset>
    <br />
    <fieldset>
        <legend>{'Class attribute to use for status'|i18n( 'design/admin/workflow/eventtype/edit' )}</legend>

        <p>
            <label class="radio" for="ClassIdentifier_{$event.id}">{'Content class'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <select id="ClassIdentifier_{$event.id}" name="ClassIdentifier_{$event.id}">
                <option value="">{'Choose a content class'|i18n( 'design/admin/workflow/eventtype/edit' )}</option>
            {foreach $classes as $class}
                <option value="{$class.identifier}"{if $event.class_identifier|eq( $class.identifier )} selected="selected"{/if}>{$class.name|wash}</option>
            {/foreach}
            </select>
            &nbsp;&nbsp;&nbsp;
            <label class="radio" for="AttributeIdentifier_{$event.id}">{'Attribute to use for status message'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <select id="AttributeIdentifier_{$event.id}" name="AttributeIdentifier_{$event.id}"{cond( $event.class_id|eq( '' ), ' disabled="disabled"', '' )}>
                <option value="">{'Choose an attribute'|i18n( 'design/admin/workflow/eventtype/edit' )}</option>
            {if $event.class_id|ne( '' )}
                {foreach fetch( class, attribute_list, hash( class_id, $event.class_id ) ) as $attribute}
                    {if $allowed_datatypes|contains( $attribute.data_type_string )}
                <option value="{$attribute.identifier}"{if $attribute.id|eq( $event.attribute_id )} selected="selected"{/if}>{$attribute.name|wash}</option>
                    {/if}
                {/foreach}
            {/if}
            </select>
        </p>

    </fieldset>
    <br />
    
    <fieldset>
        <legend>{'Class attribute to trigger the sending'|i18n( 'design/admin/workflow/eventtype/edit' )}</legend>
        <p>
            <label class="radio" for="AttributeIdentifierTrigger_{$event.id}">{'Attribute used to trigger the sending'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <select id="AttributeIdentifierTrigger_{$event.id}" name="AttributeIdentifierTrigger_{$event.id}"{cond( $event.class_id|eq( '' ), ' disabled="disabled"', '' )}>
            <optgroup label="{'Do not use an attribute'|i18n( 'design/admin/workflow/eventtype/edit' )}">
                <option value="-1" {if or( $event.trigger_attribute_id|not, eq( $event.trigger_attribute_id, -1 ) )} selected="selected"{/if}><em>{'Send every time'|i18n( 'design/admin/workflow/eventtype/edit' )}</em></option>
            </optgroup>
            {if $event.class_id|ne( '' )}
            <optgroup label="{'Available attributes'|i18n( 'design/admin/workflow/eventtype/edit' )}">                         
                {foreach fetch( class, attribute_list, hash( class_id, $event.class_id ) ) as $attribute}
                    {if $allowed_datatypes|contains( $attribute.data_type_string )}
                <option value="{$attribute.identifier}"{if $attribute.id|eq( $event.trigger_attribute_id )} selected="selected"{/if}>{$attribute.name|wash}</option>
                    {/if}
                {/foreach}
            </optgroup>                
            {/if}
            </select>
        </p>

    </fieldset>
    <br />    
    

    <fieldset>
        <legend>{'Defer status update to cronjob'|i18n( 'design/admin/workflow/eventtype/edit' )}</legend>
        <p>
            <label for="UseCronjob_{$event.id}" class="radio">{'Use cronjob to update status'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <input type="checkbox" value="1" name="UseCronjob_{$event.id}" id="UseCronjob_{$event.id}"{if $event.use_cronjob} checked="checked"{/if} />
        </p>
    </fieldset>
    <br />
    <fieldset>
        <legend>{'Siteaccess to generate URLs for'|i18n( 'design/admin/workflow/eventtype/edit' )} <em>({'only works for "host" and "uri" MatchOrder values'|i18n( 'design/admin/workflow/eventtype/edit' )})</em></legend>
        <p>
            <label for="Siteaccess_{$event.id}" class="radio">{'Choose siteaccess'|i18n( 'design/admin/workflow/eventtype/edit' )}</label>
            <select id="Siteaccess_{$event.id}" name="Siteaccess_{$event.id}">
                <option value="-1">{'Current one'|i18n( 'design/admin/workflow/eventtype/edit' )}</option>
                {foreach ezini( 'SiteAccessSettings', 'RelatedSiteAccessList' ) as $siteaccess}
                    <option value="{$siteaccess|wash}"{if $event.siteaccess|eq( $siteaccess )} selected="selected"{/if}>{$siteaccess|wash}</option>    
                {/foreach}
            </select>            
        </p>
    </fieldset>    
</div>
{undef $classes $attributes $social_networks $allowed_datatypes}

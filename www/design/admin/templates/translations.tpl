{def $translations=$node.object.languages
     $translations_count=$translations|count
     $available_languages=fetch( content, prioritized_languages )}

{if gt($available_languages,1)}

<form name="translationsform" method="post" action={'content/translation'|ezurl}>
<input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
<input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
<input type="hidden" name="ViewMode" value="{$viewmode|wash}" />
<input type="hidden" name="ContentObjectLanguageCode" value="{$language_code|wash}" />

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{'Translations [%translations]'|i18n( 'design/admin/node/view/full',, hash( '%translations', $node.object.current.language_list|count ) )}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<div class="block">
<fieldset>
<legend>{'Existing languages'|i18n( 'design/admin/node/view/full' )}</legend>

<table class="list" cellspacing="0">
<tr>
    <th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.translationsform, 'LanguageID[]' ); return false;"/></th>
    <th>{'Language'|i18n( 'design/admin/node/view/full' )}</th>
    <th>{'Locale'|i18n( 'design/admin/node/view/full' )}</th>
    <th class="tight">{'Main'|i18n( 'design/admin/node/view/full' )}</th>
    <th class="tight">&nbsp;</th>
</tr>

{section var=Translations loop=$translations sequence=array( bglight, bgdark )}
{def $can_edit=fetch( 'content', 'access', hash( 'access', 'edit',
                                                 'contentobject', $node.object,
                                                 'language', $Translations.item.locale ) )}

<tr class="{$Translations.sequence}">

{* Remove. *}
<td>
    <input type="checkbox" name="LanguageID[]" value="{$Translations.item.id}"{if or($can_edit|not,$Translations.item.id|eq($node.object.initial_language_id))} disabled="disabled"{/if} />
</td>

{* Language name. *}
<td>
<img src="{$Translations.item.locale|flag_icon}" alt="{$Translations.item.locale}" />
&nbsp;
{if eq( $Translations.item.locale, $node.object.current_language )}
<b><a href={concat( $node.url, '/(language)/', $Translations.item.locale )|ezurl} title="{'View translation.'|i18n( 'design/admin/node/view/full' )}">{$Translations.item.name}</a></b>
{else}
<a href={concat( $node.url, '/(language)/', $Translations.item.locale )|ezurl} title="{'View translation.'|i18n( 'design/admin/node/view/full' )}">{$Translations.item.name}</a>
{/if}
</td>

{* Locale code. *}
<td>{$Translations.item.locale}</td>

{* Main. *}
<td>

{if $node.object.can_edit}

<input type="radio"{if $Translations.item.id|eq($node.object.initial_language_id)} checked="checked"{/if} name="InitialLanguageID" value="{$Translations.item.id}" title="{'Use these radio buttons to select the desired main language.'|i18n( 'design/admin/node/view/full' )}" />

{/if}

</td>

{* Edit. *}
<td>

{if $can_edit}

<a href={concat( 'content/edit/', $node.object.id, '/f/', $Translations.item.locale )|ezurl}><img src={'edit.gif'|ezimage} alt="{'Edit in <%language_name>.'|i18n( 'design/admin/node/view/full',, hash( '%language_name', $Translations.item.locale_object.intl_language_name ) )|wash}" title="{'Edit in <%language_name>.'|i18n( 'design/admin/node/view/full',, hash( '%language_name', $Translations.item.locale_object.intl_language_name ) )|wash}" /></a>

{/if}

</td>

</tr>

{undef $can_edit}
{/section}
</table>

<div class="block">
<div class="button-left">
{if $node.object.can_edit}
    {if $translations_count|gt( 1 )}
    <input class="button" type="submit" name="RemoveTranslationButton" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" title="{'Remove selected languages from the list above.'|i18n( 'design/admin/node/view/full' )}" />
    {else}
    <input class="button-disabled" type="submit" name="RemoveTranslationButton" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" title="{'There is no removable language.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
    {/if}
{else}
    <input class="button-disabled" type="submit" name="" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" title="{'You cannot remove any language because you do not have permission to edit the current item.'|i18n( 'design/admin/node/view/full' )}" />
{/if}
</div>

<div class="button-right">
{if $node.object.can_edit}
    {if $translations_count|gt( 1 )}
    <input class="button" type="submit" name="UpdateInitialLanguageButton" value="{'Set main'|i18n( 'design/admin/node/view/full' )}" title="{'Select the desired main language using the radio buttons above then click this button to store the setting.'|i18n( 'design/admin/node/view/full' )}" />
    {else}
    <input class="button-disabled" type="submit" name="" value="{'Set main'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" title="{'You cannot change the main language because the object is not translated to any other languages.'|i18n( 'design/admin/node/view/full' )}" />
    {/if}
{else}
    <input class="button-disabled" type="submit" name="" value="{'Set main'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" title="{'You cannot change the main language because you do not have permission to edit the current item.'|i18n( 'design/admin/node/view/full' )}" />
{/if}
</div>

<div class="break"></div>
</div>
</fieldset>

</div>

<div class="block">
<input type="checkbox"{if $node.object.can_edit|not} disabled="disabled"{/if} name="AlwaysAvailable" value="1"{if $node.object.always_available} checked="checked"{/if} /> {'Use the main language if there is no prioritized translation.'|i18n( 'design/admin/node/view/full' )}
</div>

<div class="block">
{if $node.object.can_edit}
    <input class="button" type="submit" name="UpdateAlwaysAvailableButton" value="{'Update'|i18n( 'design/admin/node/view/full' )}" title="{'Use this button to store the value of the checkbox above.'|i18n( 'design/admin/node/view/full' )}" />
{else}
    <input class="button-disabled" disabled="disabled" type="submit" name="UpdateAlwaysAvailableButton" value="{'Update'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to change this setting.'|i18n( 'design/admin/node/view/full' )}" />
{/if}
</div>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>

</form>

{/if}

{undef $translations
       $translations_count}

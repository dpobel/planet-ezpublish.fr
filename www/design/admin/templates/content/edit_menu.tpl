<div class="objectinfo">

<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Object information'|i18n( 'design/admin/content/edit' )}</h4>

</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-br"><div class="box-bl"><div class="box-content">

{* Object ID *}
<p>
<label>{'ID'|i18n( 'design/admin/content/edit' )}:</label>
{$object.id}
</p>

{* Created *}
<p>
<label>{'Created'|i18n( 'design/admin/content/edit' )}:</label>
{if $object.published}
{$object.published|l10n( shortdatetime )}<br />
{$object.owner.name|wash}
{else}
{'Not yet published'|i18n( 'design/admin/content/edit' )}
{/if}
</p>

{* Modified *}
<p>
<label>{'Modified'|i18n( 'design/admin/content/edit' )}:</label>
{if $object.modified}
{$object.modified|l10n( shortdatetime )}<br />
{$object.current.creator.name|wash}
{else}
{'Not yet published'|i18n( 'design/admin/content/edit' )}
{/if}
</p>

{* Published version *}
<p>
<label>{'Published version'|i18n( 'design/admin/content/edit' )}:</label>
{if $object.published}
{$object.current.version}
{else}
{'Not yet published'|i18n( 'design/admin/content/edit' )}
{/if}
</p>

{* Manage versions *}
<div class="block">
{if $object.versions|count|gt( 1 )}
<input class="button" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/admin/content/edit' )}" title="{'View and manage (copy, delete, etc.) the versions of this object.'|i18n( 'design/admin/content/edit' )}" />
{else}
<input class="button-disabled" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/admin/content/edit' )}" disabled="disabled" title="{'You cannot manage the versions of this object because there is only one version available (the one that is being edited).'|i18n( 'design/admin/content/edit' )}" />
{/if}
</div>

</div></div></div></div></div></div>

</div>

<div class="drafts">

<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Current draft'|i18n( 'design/admin/content/edit' )}</h4>
</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

{* Created *}
<p>
<label>{'Created'|i18n( 'design/admin/content/edit' )}:</label>
{$content_version.created|l10n( shortdatetime )}<br />
{$content_version.creator.name|wash}
</p>

{* Modified *}
<p>
<label>{'Modified'|i18n( 'design/admin/content/edit' )}:</label>
{$content_version.modified|l10n( shortdatetime )}<br />
{$content_version.creator.name|wash}
</p>

{* Version *}
<p>
<label>{'Version'|i18n( 'design/admin/content/edit' )}:</label>
{$edit_version}
</p>

<div class="block">
<input class="button" type="submit" name="PreviewButton" value="{'View'|i18n( 'design/admin/content/edit' )}" title="{'View the draft that is being edited.'|i18n( 'design/admin/content/edit' )}" />
</div>
<div class="block">
<input class="button" type="submit" name="StoreExitButton" value="{'Store and exit'|i18n( 'design/admin/content/edit' )}" title="{'Store the draft that is being edited and exit from edit mode.'|i18n( 'design/admin/content/edit' )}" />
</div>

</div></div></div></div></div></div>
</div>

<!-- Translation box start-->
<div class="translations">

<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Translate from'|i18n( 'design/admin/content/edit' )}</h4>
</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<label>
<input type="radio" name="FromLanguage" value=""{if $from_language|not} checked="checked"{/if}{if $object.status|eq(0)} disabled="disabled"{/if} /> {'No translation'|i18n( 'design/admin/content/edit' )}
</label>

{if $object.status}
{foreach $object.languages as $language}
<label>
<input type="radio" name="FromLanguage" value="{$language.locale}"{if $language.locale|eq($from_language)} checked="checked"{/if} />
<img src="{$language.locale|flag_icon}" alt="{$language.locale}" style="vertical-align: middle;" />
{$language.name|wash}
</label>
{/foreach}
{/if}

<div class="block">
<input {if $object.status|eq(0)}class="button-disabled" disabled="disabled"{else} class="button"{/if} type="submit" name="FromLanguageButton" value="{'Translate'|i18n( 'design/admin/content/edit' )}" title="{'Edit the current object showing the selected language as a reference.'|i18n( 'design/admin/content/edit' )}" />
</div>

</div></div></div></div></div></div>
</div>

<!-- Translation box end-->

{* Edit section *}
<div class="sections">
{include uri='design:content/edit_sections.tpl'}
</div>


{* Edit states *}
<div class="states">
{include uri='design:content/edit_states.tpl'}
</div>


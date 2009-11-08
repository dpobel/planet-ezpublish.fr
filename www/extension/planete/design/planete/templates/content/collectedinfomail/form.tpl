{*
 * $Id$
 * $HeadURL$
 *}{set-block scope=root variable=subject}[Planet eZ Publish.fr] Message par le formulaire de contact{/set-block}
{set-block scope=root variable=email_sender}{$collection.data_map.email.content}{/set-block}
{set-block scope=root variable=email_reply_to}{$collection.data_map.email.content}{/set-block}

Champs remplis par l'utilisateur :

{section name=Attribute loop=$collection.attributes}
{$Attribute:item.contentclass_attribute_name|wash}:
{attribute_result_gui view=info attribute=$Attribute:item}

{/section}

{*
 * $Id$
 * $HeadURL$
 *}{set-block scope=root variable=subject}[Planet eZ Publish.fr] Message par le formulaire de contact{/set-block}

Champs remplis par l'utilisateur :

{section name=Attribute loop=$collection.attributes}
{$Attribute:item.contentclass_attribute_name|wash}:
{attribute_result_gui view=info attribute=$Attribute:item}

{/section}

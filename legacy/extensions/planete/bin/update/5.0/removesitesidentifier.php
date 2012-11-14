#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(
    array(
        'description' => "Update the post content class to not use any ezidentifier",
        'use-session' => false,
        'use-modules' => true,
        'use-extensions' => true
    )
);

$script->startup();
$script->initialize();

$db = eZDB::instance();

$identifier = 'site';
$attributeIdentifier = 'urlid';
$newAttributeIdentifier = 'idurl';


$cli->output( "Loading class '{$identifier}'" );
$class = eZContentClass::fetchByIdentifier( $identifier );
if ( !$class instanceof eZContentClass )
{
    $cli->error( "Unable to find the class with identifier {$identifier}" );
    $script->shutdown( 1 );
}

$cli->output( "Loading class attribute '{$identifier}.{$attributeIdentifier}'" );
$attribute = $class->fetchAttributeByIdentifier( $attributeIdentifier );
$attributes = $class->fetchAttributes();

if ( !$attribute instanceof eZContentClassAttribute )
{
    $cli->error(
        "Unable to find the class attribute with identifier "
        . "{$attributeIdentifier} in the class {$identifier}"
    );
    $script->shutdown( 2 );
}

$cli->output(
    "Creating the new attribute '{$identifier}.{$newAttributeIdentifier}'"
);
$newAttribute = eZContentClassAttribute::create(
    $class->attribute( 'id' ), 'ezinteger',
    array( 'name' => 'ID URL' )
);
$datatype = $newAttribute->datatype();
$datatype->initializeClassAttribute( $newAttribute );
$newAttribute->setAttribute( 'identifier', $newAttributeIdentifier );
$newAttribute->store();


$cli->output( "Removing the attribute '{$identifier}.{$attributeIdentifier}'" );
foreach ( $attributes as $k => $attr )
{
    if ( $attribute->attribute( 'id' ) == $attr->attribute( 'id' ) )
    {
        unset( $attributes[$k] );
        continue;
    }
    else
    {
        $attr->setAttribute( 'version', eZContentClass::VERSION_STATUS_TEMPORARY );
        $attr->store();
    }
}
$attributes[] = $newAttribute;
$params = array();
$db->begin();
$cli->output( "Storing the new '{$identifier}' class" );
$class->setAttribute( 'url_alias_name', '<' . $newAttributeIdentifier .  '>' );
$class->setAttribute( 'version', eZContentClass::VERSION_STATUS_TEMPORARY );
$classID = $class->attribute( 'id' );
$classGroups = eZContentClassClassGroup::fetchGroupList(
    $classID, eZContentClass::VERSION_STATUS_DEFINED
);
foreach ( $classGroups as $classGroup )
{
    $groupID = $classGroup->attribute( 'group_id' );
    $groupName = $classGroup->attribute( 'group_name' );
    $ingroup = eZContentClassClassGroup::create(
        $classID, eZContentClass::VERSION_STATUS_TEMPORARY,
        $groupID, $groupName
    );
    $ingroup->store();
}
eZExtension::getHandlerClass(
    new ezpExtensionOptions(
        array(
            'iniFile' => 'site.ini',
            'iniSection'   => 'ContentSettings',
            'iniVariable'  => 'ContentClassEditHandler'
        )
    )
)->store( $class, $attributes, $params );
$db->commit();

$cli->output( "" );
$cli->output( "Loading all '{$identifier}'" );
$sites = eZContentObjectTreeNode::subTreeByNodeID(
    array(
        'ClassFilterType' => 'include',
        'ClassFilterArray' => array( $identifier )
    ),
    eZINI::instance( 'planete.ini' )->variable(
        'TreeSettings', 'PlanetRootNodeID'
    )
);

foreach ( $sites as $site )
{
    $cli->output( "Modifying '{$site->attribute( 'name' )}'" );
    $version = $site->attribute( 'object' )->createNewVersion();
    $dataMap = $version->attribute( 'data_map' );
    $parts = explode( '/', $site->attribute( 'url_alias' ) );
    $id = array_pop( $parts );
    $cli->output( "  ID URL: '{$id}'" );
    foreach ( $dataMap as $key => $attr )
    {
        if ( $key === $newAttributeIdentifier )
        {
            $dataMap[$key]->fromString( $id );
        }
        $dataMap[$key]->store();
    }
    eZOperationHandler::execute(
        'content', 'publish',
        array(
            'object_id' => $site->attribute( 'object' )->attribute( 'id' ),
            'version' => $version->attribute( 'version' )
        )
    );
}

$cli->output( "Done" );

$script->shutdown();

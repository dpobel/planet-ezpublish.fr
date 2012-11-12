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

$identifier = 'post';
$attributeIdentifier = 'urlid';

$class = eZContentClass::fetchByIdentifier( $identifier );
if ( $class instanceof eZContentClass )
{
    $attribute = $class->fetchAttributeByIdentifier( $attributeIdentifier );
    $attributes = $class->fetchAttributes();
    if ( $attribute instanceof eZContentClassAttribute )
    {
        foreach ( $attributes as $k => $attr )
        {
            if ( $attribute->attribute( 'id' ) == $attr->attribute( 'id' ) )
            {
                unset( $attributes[$k] );
                break;
            }
        }
        $params = array();
        $db->begin();
        $class->setAttribute( 'url_alias_name', '' );
        $class->remove( false, eZContentClass::VERSION_STATUS_TEMPORARY );
        $class->setAttribute(
            'version', eZContentClass::VERSION_STATUS_TEMPORARY
        );
        $class->storeVersioned(
            $attributes, eZContentClass::VERSION_STATUS_TEMPORARY
        );
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
    }
    else
    {
        $cli->error(
            "Unable to find the class attribute with identifier "
            . "{$attributeIdentifier} in the class {$identifier}"
        );
    }
}
else
{
    $cli->error( "Unable to find the class with identifier {$identifier}" );
}


$script->shutdown();

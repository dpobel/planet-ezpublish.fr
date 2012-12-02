#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(
    array(
        'description' => "Add a datetime fields to site and post content classes",
        'use-session' => false,
        'use-modules' => true,
        'use-extensions' => true
    )
);

$script->startup();
$script->initialize();


updateContentClass( 'site', 'modification_date', 'Modification date', null, 'modified_subnode' );
updateContentClass( 'post', 'date', 'Date', 'published', null );

function updateContentClass( $identifier, $dtIdentifier, $dtName, $metaDateObject, $metaDateNode )
{
    $db = eZDB::instance();
    $cli = eZCLI::instance();
    $cli->output( "Loading class '{$identifier}'" );
    $class = eZContentClass::fetchByIdentifier( $identifier );
    if ( !$class instanceof eZContentClass )
    {
        $cli->error( "Unable to find the class with identifier {$identifier}" );
        $script->shutdown( 1 );
    }
    $attributes = $class->fetchAttributes();

    $cli->output(
        "Creating the new attribute '{$identifier}.{$dtIdentifier}'"
    );
    $newAttribute = eZContentClassAttribute::create(
        $class->attribute( 'id' ), 'ezdatetime',
        array( 'name' => $dtName )
    );
    $datatype = $newAttribute->datatype();
    $datatype->initializeClassAttribute( $newAttribute );
    $newAttribute->setAttribute( 'identifier', $dtIdentifier );
    $newAttribute->store();

    foreach ( $attributes as $k => $attr )
    {
        $attr->setAttribute(
            'version', eZContentClass::VERSION_STATUS_TEMPORARY
        );
        $attr->store();
    }
    $attributes[] = $newAttribute;
    $params = array();
    $db->begin();
    $cli->output( "Storing the new '{$identifier}' class" );
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
    $offset = 0;
    $limit = 100;
    while ( true )
    {
        $sites = eZContentObjectTreeNode::subTreeByNodeID(
            array(
                'ClassFilterType' => 'include',
                'ClassFilterArray' => array( $identifier ),
                'Limit' => $limit,
                'Offset' => $offset,
            ),
            eZINI::instance( 'planete.ini' )->variable(
                'TreeSettings', 'PlanetRootNodeID'
            )
        );
        if ( empty( $sites ) )
            break;
        $offset += $limit;

        foreach ( $sites as $site )
        {
            $cli->output( "Modifying '{$site->attribute( 'name' )}'" );
            $version = $site->attribute( 'object' )->createNewVersion();
            $dataMap = $version->attribute( 'data_map' );
            foreach ( $dataMap as $key => $attr )
            {
                if ( $key === $dtIdentifier )
                {
                    $dataMap[$key]->fromString(
                        $metaDateObject ? $site->object()->attribute( $metaDateObject ) : $site->attribute( $metaDateNode )
                    );
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
    }
    $cli->output( "Done" );
}

$script->shutdown();

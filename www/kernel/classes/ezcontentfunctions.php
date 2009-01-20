<?php

//
// Created on: <13-Nov-2006 15:00:00 dl>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

class eZContentFunctions
{
    static function createAndPublishObject( $params )
    {
        //include_once( 'kernel/classes/ezcontentobject.php' );
        //include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
        //include_once( 'lib/ezlocale/classes/ezdatetime.php' );

        $parentNodeID = $params['parent_node_id'];
        $classIdentifier = $params['class_identifier'];
        $creatorID = isset( $params['creator_id'] ) ? $params['creator_id'] : false;
        $attributesData = isset( $params['attributes'] ) ? $params['attributes'] : false;
        $storageDir = isset( $params['storage_dir'] ) ? $params['storage_dir'] : '';

        $contentObject = false;

        $parentNode = eZContentObjectTreeNode::fetch( $parentNodeID, false, false );

        if ( is_array( $parentNode ) )
        {
            $contentClass = eZContentClass::fetchByIdentifier( $classIdentifier );
            if ( is_object( $contentClass ) )
            {
                $db = eZDB::instance();
                $db->begin();

                $contentObject = $contentClass->instantiate( $creatorID );
                $contentObject->store();

                $nodeAssignment = eZNodeAssignment::create( array( 'contentobject_id' => $contentObject->attribute( 'id' ),
                                                                   'contentobject_version' => $contentObject->attribute( 'current_version' ),
                                                                   'parent_node' => $parentNodeID,
                                                                   'is_main' => 1,
                                                                   'sort_field' => $contentClass->attribute( 'sort_field' ),
                                                                   'sort_order' => $contentClass->attribute( 'sort_order' ) ) );
                $nodeAssignment->store();

                $version = $contentObject->version( 1 );
                $version->setAttribute( 'modified', eZDateTime::currentTimeStamp() );
                $version->setAttribute( 'status', eZContentObjectVersion::STATUS_DRAFT );
                $version->store();

                if ( is_array( $attributesData ) && count( $attributesData ) > 0 )
                {
                    $attributes = $contentObject->attribute( 'contentobject_attributes' );

                    foreach( $attributes as $attribute )
                    {
                        $attributeIdentifier = $attribute->attribute( 'contentclass_attribute_identifier' );
                        if ( isset( $attributesData[$attributeIdentifier] ) )
                        {
                            $dataString = $attributesData[$attributeIdentifier];
                            switch ( $datatypeString = $attribute->attribute( 'data_type_string' ) )
                            {
                                case 'ezimage':
                                case 'ezbinaryfile':
                                case 'ezmedia':
                                {
                                    $dataString = $storageDir . $dataString;
                                    break;
                                }
                                default:
                            }

                            $attribute->fromString( $dataString );
                            $attribute->store();
                        }
                    }
                }

                $db->commit();

                //include_once( 'lib/ezutils/classes/ezoperationhandler.php' );
                $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObject->attribute( 'id' ),
                                                                                             'version' => 1 ) );
            }
            else
            {
                eZDebug::writeError( "Content class with identifier '$classIdentifier' doesn't exist.", 'eZContentFunctions::createAndPublishObject' );
            }
        }
        else
        {
            eZDebug::writeError( "Node with id '$parentNodeID' doesn't exist.", 'eZContentFunctions::createAndPublishObject' );
        }

        return $contentObject;
    }
}

?>

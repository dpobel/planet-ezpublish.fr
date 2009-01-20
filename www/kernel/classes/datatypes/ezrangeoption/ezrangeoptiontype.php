<?php
//
// Definition of eZRangeOptionType class
//
// Created on: <17-Feb-2003 16:24:57 sp>
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

/*! \file ezrangeoptiontype.php
*/

/*!
  \class eZRangeOptionType ezrangeoptiontype.php
  \ingroup eZDatatype
  \brief The class eZRangeOptionType does

*/
//include_once( "kernel/classes/ezdatatype.php" );
//include_once( "kernel/classes/datatypes/ezrangeoption/ezrangeoption.php" );

class eZRangeOptionType extends eZDataType
{
    const DEFAULT_NAME_VARIABLE = "_ezrangeoption_default_name_";

    const DATA_TYPE_STRING = "ezrangeoption";

    /*!
     Constructor
    */
    function eZRangeOptionType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n( 'kernel/classes/datatypes', "Range option", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_rangeoption_name_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . '_data_rangeoption_start_value_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_data_rangeoption_stop_value_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_data_rangeoption_step_value_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {

            $name = $http->postVariable( $base . "_data_rangeoption_name_" . $contentObjectAttribute->attribute( "id" ) );
            $startValue = $http->postVariable( $base . '_data_rangeoption_start_value_' . $contentObjectAttribute->attribute( 'id' ) );
            $stopValue = $http->postVariable( $base . '_data_rangeoption_stop_value_' . $contentObjectAttribute->attribute( 'id' ) );
            $stepValue = $http->postVariable( $base . '_data_rangeoption_step_value_' . $contentObjectAttribute->attribute( 'id' ) );
            $classAttribute = $contentObjectAttribute->contentClassAttribute();
            if ( $name == '' or
                 $startValue == '' or
                 $stopValue == '' or
                 $stepValue == '' )
            {
                if ( ( !$classAttribute->attribute( 'is_information_collector' ) and
                       $contentObjectAttribute->validateIsRequired() ) )
                {
                    $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                     'Missing range option input.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
                else
                    return eZInputValidator::STATE_ACCEPTED;
            }
        }
        else
        {
            return eZInputValidator::STATE_ACCEPTED;
        }


    }

    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {

        $optionName = $http->postVariable( $base . "_data_rangeoption_name_" . $contentObjectAttribute->attribute( "id" ) );
        if ( $http->hasPostVariable( $base . "_data_rangeoption_id_" . $contentObjectAttribute->attribute( "id" ) ) )
            $optionIDArray = $http->postVariable( $base . "_data_rangeoption_id_" . $contentObjectAttribute->attribute( "id" ) );
        else
            $optionIDArray = array();
        $optionStartValue = $http->postVariable( $base . "_data_rangeoption_start_value_" . $contentObjectAttribute->attribute( "id" ) );
        $optionStopValue = $http->postVariable( $base . "_data_rangeoption_stop_value_" . $contentObjectAttribute->attribute( "id" ) );
        $optionStepValue = $http->postVariable( $base . "_data_rangeoption_step_value_" . $contentObjectAttribute->attribute( "id" ) );

        $option = new eZRangeOption( $optionName );

        $option->setStartValue( $optionStartValue );
        $option->setStopValue( $optionStopValue );
        $option->setStepValue( $optionStepValue );

/*        $i = 0;
        foreach ( $optionIDArray as $id )
        {
            $option->addOption( array( 'value' => $optionValueArray[$i],
                                       'additional_price' => $optionAdditionalPriceArray[$i] ) );
            $i++;
        }
*/
        $contentObjectAttribute->setContent( $option );
        return true;
    }

    function storeObjectAttribute( $contentObjectAttribute )
    {
        $option = $contentObjectAttribute->content();
        $contentObjectAttribute->setAttribute( "data_text", $option->xmlString() );
    }

    function objectAttributeContent( $contentObjectAttribute )
    {
        $option = new eZRangeOption( "" );
        $option->decodeXML( $contentObjectAttribute->attribute( "data_text" ) );
        return $option;
    }

    function toString( $contentObjectAttribute )
    {

        $option = $contentObjectAttribute->attribute( 'content' );
        $optionArray = array();
        $optionArray[] = $option->attribute( 'name' );
        $optionArray[] = $option->attribute( 'start_value' );
        $optionArray[] = $option->attribute( 'stop_value' );
        $optionArray[] = $option->attribute( 'step_value' );

        return implode( '|', $optionArray );
    }


    function fromString( $contentObjectAttribute, $string )
    {
        if ( $string == '' )
            return true;

        $optionArray = explode( '|', $string );

        $option = new eZRangeOption( '' );

        $option->Name = array_shift( $optionArray );
        $option->StartValue = array_shift( $optionArray );
        $option->StopValue = array_shift( $optionArray );
        $option->StepValue = array_shift( $optionArray );


        $contentObjectAttribute->setAttribute( "data_text", $option->xmlString() );

        return $option;

    }
    /*!
     Finds the option which has the ID that matches \a $optionID, if found it returns
     an option structure.
    */
    function productOptionInformation( $objectAttribute, $optionID, $productItem )
    {
        $option = $objectAttribute->attribute( 'content' );
        foreach( $option->attribute( 'option_list' ) as $optionArray )
        {
            if ( $optionArray['id'] == $optionID )
            {
                return array( 'id' => $optionArray['id'],
                              'name' => $option->attribute( 'name' ),
                              'value' => $optionArray['value'],
                              'additional_price' => $optionArray['additional_price'] );
            }
        }
        return false;
    }

    function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }

    function title( $contentObjectAttribute, $name = null )
    {
        $option = new eZRangeOption( "" );
        $option->decodeXML( $contentObjectAttribute->attribute( "data_text" ) );
        return $option->attribute('name');
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return true;
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion == false )
        {
            $option = $contentObjectAttribute->content();
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            if ( !$option )
            {
                $option = new eZRangeOption( $contentClassAttribute->attribute( 'data_text1' ) );
            }
            else
            {
                $option->setName( $contentClassAttribute->attribute( 'data_text1' ) );
            }
            $contentObjectAttribute->setAttribute( "data_text", $option->xmlString() );
            $contentObjectAttribute->setContent( $option );
        }
    }

    /*!
     \reimp
    */
    function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        $defaultValueName = $base . self::DEFAULT_NAME_VARIABLE . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $defaultValueName ) )
        {
            $defaultValueValue = $http->postVariable( $defaultValueName );

            if ($defaultValueValue == ""){
                $defaultValueValue = "";
            }
            $classAttribute->setAttribute( 'data_text1', $defaultValueValue );
            return true;
        }
        return false;
    }

    /*!
     \reimp
    */
    function serializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $defaultName = $classAttribute->attribute( 'data_text1' );
        $defaultNameNode = $attributeParametersNode->ownerDocument->createElement( 'default-name', $defaultName );
        $attributeParametersNode->appendChild( $defaultNameNode );
    }

    /*!
     \reimp
    */
    function unserializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $defaultName = $attributeParametersNode->getElementsByTagName( 'default-name' )->item( 0 )->textContent;
        $classAttribute->setAttribute( 'data_text1', $defaultName );
    }

    /*!
     \reimp
    */
    function serializeContentObjectAttribute( $package, $objectAttribute )
    {
        $node = $this->createContentObjectAttributeDOMNode( $objectAttribute );

        $domDocument = new DOMDocument( '1.0', 'utf-8' );
        $success = $domDocument->loadXML( $objectAttribute->attribute( 'data_text' ) );

        $importedRoot = $node->ownerDocument->importNode( $domDocument->documentElement, true );
        $node->appendChild( $importedRoot );

        return $node;
    }

    /*!
     \reimp
    */
    function unserializeContentObjectAttribute( $package, $objectAttribute, $attributeNode )
    {
        $rootNode = $attributeNode->getElementsByTagName( 'ezrangeoption' )->item( 0 );
        $xmlString = $rootNode ? $rootNode->ownerDocument->saveXML( $rootNode ) : '';
        $objectAttribute->setAttribute( 'data_text', $xmlString );
    }
}

eZDataType::register( eZRangeOptionType::DATA_TYPE_STRING, "eZRangeOptionType" );

?>

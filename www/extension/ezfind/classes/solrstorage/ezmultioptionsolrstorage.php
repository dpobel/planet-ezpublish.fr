<?php

/**
 * File containing the ezmultioptionSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezmultioptionSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $content = $contentObjectAttribute->attribute( 'content' );
        $multioptionArray = array(
            'name' => $content->attribute( 'name' ),
        );

        foreach ( $content->attribute( 'multioption_list' ) as $option )
        {
            $optionArray = array(
                'name' => $option['name'],
                'default_option_id' => $option['default_option_id']
            );
            foreach ( $option['optionlist'] as $value )
            {
                $optionArray['optionlist'][] = array(
                    'value' => $value['value'],
                    'additional_price' => $value['additional_price']
                );
            }
            $multioptionArray['multioption_list'][] = $optionArray;
        }

        return array(
            'content' => $multioptionArray,
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

<?php

/**
 * File containing the ezoptionSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezoptionSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $content = $contentObjectAttribute->attribute( 'content' );
        $optionArray = array(
            'name' => $content->attribute( 'name' ),
        );

        foreach ( $content->attribute( 'option_list' ) as $value )
        {
            $optionArray['option_list'][] = array(
                'id' => $value['id'],
                'value' => $value['value'],
                'additional_price' => $value['additional_price'],
                'is_default' => $value['is_default'],
            );
        }

        return array(
            'content' => $optionArray,
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

<?php

/**
 * File containing the ezpriceSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezpriceSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $price = $contentObjectAttribute->attribute( 'content' );

        return array(
            'content' => array(
                'price' => $price->attribute( 'price' ),
                'selected_vat_type' => $price->attribute( 'selected_vat_type' )->attribute( 'id' ),
                'is_vat_included' => (bool)$price->attribute( 'is_vat_included' ),
            ),
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

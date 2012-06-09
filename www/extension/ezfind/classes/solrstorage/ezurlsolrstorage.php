<?php

/**
 * File containing the ezurlSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezurlSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $url = eZURL::fetch( $contentObjectAttribute->attribute( 'data_int' ) );
        return array(
            'content' => array(
                'url' => ( $url instanceof eZURL ) ? $url->attribute( 'url' ) : null,
                'text' => $contentObjectAttribute->attribute( 'data_text' ),
            ),
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

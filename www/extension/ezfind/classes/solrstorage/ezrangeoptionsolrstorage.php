<?php

/**
 * File containing the ezrangeoptionSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezrangeoptionSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $option = $contentObjectAttribute->attribute( 'content' );

        return array(
            'content' => array(
                'name' => $option->attribute( 'name' ),
                'start_value' => $option->attribute( 'start_value' ),
                'stop_value' => $option->attribute( 'stop_value' ),
                'step_value' => $option->attribute( 'step_value' ),
            ),
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

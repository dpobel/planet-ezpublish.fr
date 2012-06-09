<?php

/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @author pb
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 *
 */

class ezmatrixSolrStorage extends ezdatatypeSolrStorage
{

    /**
     * Returns the content of the matrix to be stored in Solr
     *
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $rows = $contentObjectAttribute->content()->attribute( 'rows' );
        $target = array(
            'has_rendered_content' => false,
            'rendered' => null,
            'content' => array()
        );
        foreach( $rows['sequential'] as $elt )
        {
            $target['content'][] = $elt['columns'];
        }
        return $target;
    }

}


?>

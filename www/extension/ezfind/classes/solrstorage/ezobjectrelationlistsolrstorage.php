<?php

/**
 * File containing the ezobjectrelationlistSolrStorage class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 2.7.0
 * @package ezfind
 */

class ezobjectrelationlistSolrStorage extends ezdatatypeSolrStorage
{
    /**
     * @param eZContentObjectAttribute $contentObjectAttribute the attribute to serialize
     * @param eZContentClassAttribute $contentClassAttribute the content class of the attribute to serialize
     * @return array
     */
    public static function getAttributeContent( eZContentObjectAttribute $contentObjectAttribute, eZContentClassAttribute $contentClassAttribute )
    {
        $objectAttributeContent = $contentObjectAttribute->attribute( 'content' );
        $objectIDList = array();
        foreach ( $objectAttributeContent['relation_list'] as $objectInfo )
        {
            $objectIDList[] = $objectInfo['contentobject_id'];
        }

        return array(
            'content' => $objectIDList,
            'has_rendered_content' => false,
            'rendered' => null,
        );
    }
}

?>

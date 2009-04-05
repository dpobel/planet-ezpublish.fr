<?php
/**
 * File containing the abstract eZ XML link converter class
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class for conversions of links, given as natural URLs into the eZXml storage
 * format, which may result in urlIds, nodeIds, or similar.
 *
 * @package Document
 * @version 1.1.1
 */
abstract class ezcDocumentEzXmlLinkConverter
{
    /**
     * Get URL properties
     *
     * Return an array of the attributes, which should be set for the link.
     *
     * @param string $url 
     * @return array
     */
    abstract public function getUrlProperties( $url );
}

?>

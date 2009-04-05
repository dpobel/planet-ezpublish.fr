<?php
/**
 * File containing the ezcTreeXmlDataStore interface.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.1.2
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXmlDataStore is an interface defining common methods for XML based
 * data stores.
 *
 * @package Tree
 * @version 1.1.2
 */
interface ezcTreeXmlDataStore extends ezcTreeDataStore
{
    /**
     * Associates the DOM tree for which this data store stores data for with
     * this store.
     *
     * @param DOMDocument $dom
     */
    public function setDomTree( DOMDocument $dom );
}
?>

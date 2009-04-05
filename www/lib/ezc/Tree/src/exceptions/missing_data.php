<?php
/**
 * File containing the ezcTreeDataStoreMissingDataException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.1.2
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when a node is added through the ArrayAccess
 * interface with a key that is different from the node's ID.
 *
 * @package Tree
 * @version 1.1.2
 */
class ezcTreeDataStoreMissingDataException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeDataStoreMissingDataException.
     *
     * @param string $nodeId
     */
    public function __construct( $nodeId )
    {
        parent::__construct( "The data store does not have data stored for the node with ID '$nodeId'." );
    }
}
?>

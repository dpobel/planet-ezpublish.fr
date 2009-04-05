<?php
/**
 * File containing the ezcTreeUnknownIdException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.1.2
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when a node is request through an unknown
 * (non-existing) ID.
 *
 * @package Tree
 * @version 1.1.2
 */
class ezcTreeUnknownIdException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeUnknownIdException for the ID $nodeId.
     *
     * @param string $nodeId
     */
    public function __construct( $nodeId )
    {
        parent::__construct( "The node with ID '{$nodeId}' could not be found." );
    }
}
?>

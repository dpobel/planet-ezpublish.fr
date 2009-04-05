<?php
/**
 * File containing the ezcArchiveInternalException class.
 *
 * @package Archive
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception used when an internal errors occurs in the Archive component.
 *
 * @package Archive
 * @version 1.3.2
 */
class ezcArchiveInternalException extends ezcArchiveException
{
    /**
     * Construct an internal archive exception.
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( "Internal error: " . $message );
    }
}
?>

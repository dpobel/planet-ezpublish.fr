<?php
/**
 * File containing the ezcSystemInfoReaderCantScanOSException class
 * 
 * @package SystemInformation
 * @version 1.0.7
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reader can't scan OS for system values exception.
 *
 * Throws when system information source (file, registry, etc.)
 * is not available.
 *
 * @package SystemInformation
 * @version 1.0.7
 */
class ezcSystemInfoReaderCantScanOSException extends Exception
{
    /**
     * Construct a reader can't scan OS exception.
     *
     * @param string $msg
     */
    function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>

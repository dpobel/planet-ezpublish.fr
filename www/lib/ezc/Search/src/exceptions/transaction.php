<?php
/**
 * File containing the ezcSearchTransactionException class.
 *
 * @package Search
 * @version 1.0.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown in case something with a transaction goes wrong.
 *
 * @package Search
 * @version 1.0.3
 */
class ezcSearchTransactionException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchTransactionException
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

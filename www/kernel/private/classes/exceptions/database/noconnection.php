<?php
/**
 * File containing the eZDBNoConnectionException class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version 4.3.0
 * @package kernel
 */

/**
 * Class representing a no connection exception
 *
 * @version 4.3.0
 * @package kernel
 */

class eZDBNoConnectionException extends eZDBException
{
    /**
     * Constructs a new eZDBNoConnectionException
     *
     * @param string $host The hostname
     * @return void
     */
    function __construct( $host )
    {
        parent::__construct( "Unable to connect to the database server '{$host}'" );
    }
}
?>

<?php
/**
 * File containing the eZDBNoConnectionException class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/**
 * Class representing a no connection exception
 *
 * @version  2012.5
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
    function __construct( $host, $errorMessage, $errorNumber )
    {
        parent::__construct( "Unable to connect to the database server '{$host}'\nError #{$errorNumber}: {$errorMessage}" );
    }
}
?>

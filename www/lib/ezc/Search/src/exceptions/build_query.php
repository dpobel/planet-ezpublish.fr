<?php
/**
 * File containing the ezcSearchBuildQueryException class.
 *
 * @package Search
 * @version 1.0.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the query builder can not parse the query string.
 *
 * @package Search
 * @version 1.0.3
 */
class ezcSearchBuildQueryException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchBuildQueryException
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

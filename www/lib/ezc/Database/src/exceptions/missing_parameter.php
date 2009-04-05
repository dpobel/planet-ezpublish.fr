<?php
/**
 * File containing the ezcDbException class.
 *
 * @package Database
 * @version 1.4.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when a database handler misses a required parameter.
 *
 * @package Database
 * @version 1.4.3
 */
class ezcDbMissingParameterException extends ezcDbException
{
    /**
     * Constructs a new exception.
     *
     * @param string $option
     * @param string $variableName
     */
    public function __construct( $option, $variableName )
    {
        parent::__construct( "The option '{$option}' is required in the parameter '{$variableName}'." );
    }
}
?>

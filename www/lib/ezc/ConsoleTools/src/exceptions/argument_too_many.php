<?php
/**
 * File containing the ezcConsoleTooManyArgumentsException.
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if only a certain number of arguments were expected, but more were submitted.
 * This exception can be caught using {@link ezcConsoleOptionException}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleTooManyArgumentsException extends ezcConsoleArgumentException
{
    /**
     * Creates a new exception object. 
     * 
     * @param array(int=>string) $args Arguments array.
     * @param int $i                   Index in the arguments array.
     * @return void
     */
    public function __construct( $args, $i )
    {
        parent::__construct( "Only " . ( $i - 1 ) . " arguments are expected, but " . ( count( $args ) - 1 ) . " were submitted." );
    }
}

?>

<?php
/**
 * File containing the ezcConsoleOptionArgumentsViolationException.
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An option excludes the usage of arguments, but there were arguments submitted.
 * This exception can be caught using {@link ezcConsoleOptionException}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleOptionArgumentsViolationException extends ezcConsoleOptionException
{
    /**
     * Creates a new exception object.
     * 
     * @param ezcConsoleOption $option The violating option. 
     * @return void
     */
    public function __construct( ezcConsoleOption $option )
    {
        parent::__construct( "The option with long name '{$option->long}' excludes the usage of arguments, but arguments have been submitted." );
    }
}

?>

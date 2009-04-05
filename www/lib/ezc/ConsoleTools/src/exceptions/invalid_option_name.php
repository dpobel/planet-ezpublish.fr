<?php
/**
 * File containing the ezcConsoleInvalidOptionNameException.
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if an invalid option name (containing whitespaces or starting with 
 * a "-") was received by {@link ezcConsoleOption::__construct}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleInvalidOptionNameException extends ezcConsoleException
{
    /**
     * Creates a new exception object. 
     * 
     * @param string $name The affected option name.
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( "The option name '{$name}' is invalid." );
    }
}

?>

<?php
/**
 * File containing the ezcConsoleOptionAlreadyRegisteredException.
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The option name you tried to register is already in use.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleOptionAlreadyRegisteredException extends ezcConsoleException
{
    /**
     * Creates a new exception object. 
     * 
     * @param string $name Name of the affected option.
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( "An option with the name '{$name}' is already registered." );
    }
}

?>

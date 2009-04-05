<?php
/**
 * File containing the ezcConsoleOptionNotExistsException
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Occurs if the requested option is not registered.
 * This exception can be caught using {@link ezcConsoleOptionException}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleOptionNotExistsException extends ezcConsoleOptionException
{
    /**
     * Creates a new exception object. 
     * 
     * @param string $name Name of the already existing option.
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( "The referenced parameter '{$name}' is not registered." );
    }
}
?>

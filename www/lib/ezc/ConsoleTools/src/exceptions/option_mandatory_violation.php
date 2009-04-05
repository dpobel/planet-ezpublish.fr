<?php
/**
 * File containing the ezcConsoleOptionMandatoryViolationException.
 * 
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An option was marked to be mandatory but was not submitted.
 * This exception can be caught using {@link ezcConsoleOptionException}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleOptionMandatoryViolationException extends ezcConsoleOptionException
{
    /**
     * Creates a new exception object. 
     * 
     * @param ezcConsoleOption $option The violating option.
     * @return void
     */
    public function __construct( ezcConsoleOption $option )
    {
        parent::__construct( "Option with long name '{$option->long}' is mandatory but was not submitted." );
    }
}

?>

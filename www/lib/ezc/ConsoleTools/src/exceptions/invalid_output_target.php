<?php
/**
 * File containing the ezcConsoleInvalidOutputTargetException.
 *
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a given target {@link ezcConsoleOutputFormat} could not be opened.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleInvalidOutputTargetException extends ezcConsoleException
{
    
    /**
     * Creates a new exception object.
     * 
     * @param string $target Affected target.
     * @return void
     */
    public function __construct( $target )
    {
        parent::__construct( "The target '{$target}' could not be opened for writing." );
    }

}
?>

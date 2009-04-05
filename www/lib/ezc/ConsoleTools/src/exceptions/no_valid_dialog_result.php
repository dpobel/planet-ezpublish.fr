<?php
/**
 * File containing the ezcConsoleNoValidDialogResultException.
 *
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if {@link ezcConsoleDialog::getResult()} is called before a valid
 * result was received.
 *
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleNoValidDialogResultException extends ezcConsoleException
{
    
    /**
     * Creates a new exception object.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct( "The dialog did not receive a valid result, yet." );
    }

}
?>

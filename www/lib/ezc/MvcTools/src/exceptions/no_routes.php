<?php
/**
 * File containing the ezcMvcNoRoutesException class.
 *
 * @package MvcTools
 * @version 1.0
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the createRoutes() method does not return any routes.
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcNoRoutesException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcNoRoutesException
     */
    public function __construct()
    {
        parent::__construct( "No routes are defined in the router." );
    }
}
?>

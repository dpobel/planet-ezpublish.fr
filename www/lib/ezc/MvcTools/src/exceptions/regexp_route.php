<?php
/**
 * File containing the ezcMvcRegexpRouteException class.
 *
 * @package MvcTools
 * @version 1.0
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the prefix() method can't prefix the route's
 * pattern.
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcRegexpRouteException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcRegexpRouteException
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

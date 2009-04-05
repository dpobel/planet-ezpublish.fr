<?php
/**
 * File containing the ezcMvcNoZonesException class.
 *
 * @package MvcTools
 * @version 1.0
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the createZones() method does not return any zones.
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcNoZonesException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcNoZonesException
     */
    public function __construct()
    {
        parent::__construct( "No zones are defined in the view." );
    }
}
?>

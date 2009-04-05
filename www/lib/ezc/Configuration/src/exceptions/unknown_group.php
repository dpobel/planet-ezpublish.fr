<?php
/**
 * File containing the ezcConfigurationException class
 *
 * @package Configuration
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if the specified group does not exist in the settings.
 *
 * @package Configuration
 * @version 1.3.2
 */
class ezcConfigurationUnknownGroupException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationUnknownGroupException.
     *
     * @param string $groupName
     * @return void
     */
    function __construct( $groupName )
    {
        parent::__construct( "The settings group '{$groupName}' does not exist." );
    }
}
?>

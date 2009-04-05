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
 * Exception that is thrown if the specified setting does not exist in the settings.
 *
 * @package Configuration
 * @version 1.3.2
 */
class ezcConfigurationUnknownSettingException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationUnknownSettingException.
     *
     * @param string $groupName
     * @param string $settingName
     * @return void
     */
    function __construct( $groupName, $settingName )
    {
        parent::__construct( "The setting '{$groupName}', '{$settingName}' does not exist." );
    }
}
?>

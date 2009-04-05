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
 * Exception that is thrown if the name of a setting is not a string.
 *
 * @package Configuration
 * @version 1.3.2
 */
class ezcConfigurationSettingnameNotStringException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationSettingnameNotStringException for setting $settingName.
     *
     * @param string $settingName
     * @return void
     */
    function __construct( $settingName )
    {
        $settingNameType = gettype( $settingName );
        parent::__construct( "The setting name that was passed is not a string, but an '{$settingNameType}'." );
    }
}
?>

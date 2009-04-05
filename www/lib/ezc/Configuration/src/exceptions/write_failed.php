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
 * Exception that is thrown if the write operation for the configuration failed.
 *
 * @package Configuration
 * @version 1.3.2
 */
class ezcConfigurationWriteFailedException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationWriteFailedException.
     *
     * @param string $path
     * @return void
     */
    function __construct( $path )
    {
        parent::__construct( "The file could not be stored in '{$path}'." );
    }
}
?>

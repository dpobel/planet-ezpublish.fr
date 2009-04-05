<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.2
 * @filesource
 * @package Translation
 */

/**
 * Thrown when a required configuration setting was not made for a backend.
 *
 * @package Translation
 * @version 1.2
 */
class ezcTranslationNotConfiguredException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationNotConfiguredException.
     *
     * @param string $location
     * @return void
     */
    function __construct( $location )
    {
        parent::__construct( "Location '{$location}' is invalid." );
    }
}
?>

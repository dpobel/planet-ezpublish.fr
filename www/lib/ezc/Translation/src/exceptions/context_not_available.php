<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.2
 * @filesource
 * @package Translation
 */

/**
 * Thrown by the getContext() method when a requested context doesn't exist.
 *
 * @package Translation
 * @version 1.2
 */
class ezcTranslationContextNotAvailableException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationContextNotAvailableException.
     *
     * @param string $contextName
     * @return void
     */
    function __construct( $contextName )
    {
        parent::__construct( "The context '{$contextName}' does not exist." );
    }
}
?>

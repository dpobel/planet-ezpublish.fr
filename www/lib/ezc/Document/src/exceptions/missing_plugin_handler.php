<?php
/**
 * Wiki missing plugin handler exception
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when a wiki contains a plugin, for which no handler has
 * been registerd.
 *
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentWikiMissingPluginHandlerException extends ezcDocumentException
{
    /**
     * Construct exception from directive name
     * 
     * @param string $name 
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( 
            "No plugin handler registered for plugin '{$name}'."
        );
    }
}

?>

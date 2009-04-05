<?php
/**
 * File containing the ezcSearchDefinitionProvider class
 *
 * @package Search
 * @version 1.0.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Defines the interface for all classes that can provide a definition through the ezcSearchEmbeddedManager.
 *
 * @version 1.0.3
 * @package Search
 */
interface ezcSearchDefinitionProvider
{
    /**
     * Returns the definition for the document.
     *
     * @throws ezcSearchDefinitionNotFoundException if no such definition can be found.
     * @return ezcSearchDocumentDefinition
     */
    static public function getDefinition();
}
?>

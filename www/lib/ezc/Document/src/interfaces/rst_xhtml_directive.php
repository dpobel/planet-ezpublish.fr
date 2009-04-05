<?php
/**
 * File containing the rst XHtml directive interface
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for directives also supporting HTML output
 * 
 * @package Document
 * @version 1.1.1
 */
interface ezcDocumentRstXhtmlDirective
{
    /**
     * Transform directive to HTML
     *
     * Create a XHTML structure at the directives position in the document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toXhtml( DOMDocument $document, DOMElement $root );
}

?>

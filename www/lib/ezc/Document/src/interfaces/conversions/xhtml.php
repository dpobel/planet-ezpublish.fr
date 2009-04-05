<?php
/**
 * XHtml conversion interface
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An interface indicating the ability to transform a document directly into
 * XHTML.
 * 
 * @package Document
 * @version 1.1.1
 */
interface ezcDocumentXhtmlConversion
{
    /**
     * Return document compiled to the XHTML format
     * 
     * The internal document structure is compiled to the XHTML format and the
     * resulting XHTML document is returned.
     *
     * This is an optional interface for document markup languages which
     * support a direct transformation to XHTML as a shortcut.
     *
     * @return ezcDocumentXhtml
     */
    public function getAsXhtml();
}

?>

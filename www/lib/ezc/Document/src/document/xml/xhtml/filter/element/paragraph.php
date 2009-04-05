<?php
/**
 * File containing the ezcDocumentXhtmlParagraphElementFilter class
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml table cells.
 *
 * Tables, where the rows are nor structured into a tbody and thead are
 * restructured into those by this filter.
 * 
 * @package Document
 * @version 1.1.1
 * @access private
 */
class ezcDocumentXhtmlParagraphElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        // Only decorate non-empty paragraphs
        if ( trim( $element->textContent ) &&
             ( $element->getProperty( 'type' ) === false ) )
        {
            $element->setProperty( 'type', 'para' );
        }
    }

    /**
     * Check if filter handles the current element
     *
     * Returns a boolean value, indicating weather this filter can handle
     * the current element.
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function handles( DOMElement $element )
    {
        return ( $element->tagName === 'p' );
    }
}

?>

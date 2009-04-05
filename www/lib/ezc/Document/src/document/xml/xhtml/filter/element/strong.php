<?php
/**
 * File containing the ezcDocumentXhtmlStrongElementFilter class
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml strong emphasis.
 * 
 * Even there is no real strong empasis in docbook this may be annotated by
 * the additional attribute role, which is set for XHtml elements
 * indicating strong emphasis.
 *
 * @package Document
 * @version 1.1.1
 * @access private
 */
class ezcDocumentXhtmlStrongElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $element->setProperty( 'type', 'emphasis' );
        $element->setProperty( 'attributes', array( 
            'Role' => 'strong',
        ) );
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
        return ( ( $element->tagName === 'strong' ) ||
                 ( $element->tagName === 'b' ) );
    }
}

?>

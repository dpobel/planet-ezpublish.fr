<?php
/**
 * File containing the ezcDocumentXhtmlElementMappingFilter class
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml elements, which just do require some plain mapping to
 * semantic docbook elements.
 * 
 * @package Document
 * @version 1.1.1
 * @access private
 */
class ezcDocumentXhtmlElementMappingFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Mapping of XHtml elements to their semantic meanings.
     * 
     * @var array
     */
    protected $nameMapping = array(
        'abbr'       => 'abbrev',
        'acronym'    => 'acronym',
        'big'        => 'emphasis',
        'blockquote' => 'blockquote',
        'dl'         => 'variablelist',
        'dt'         => 'term',
        'dd'         => 'listitem',
        'em'         => 'emphasis',
        'head'       => 'sectioninfo',
        'hr'         => 'beginpage',
        'html'       => 'section',
        'i'          => 'emphasis',
        'li'         => 'listitem',
        'q'          => 'blockquote',
        'title'      => 'title',
        'tt'         => 'literal',
        'table'      => 'table',
        'td'         => 'entry',
        'th'         => 'entry',
        'tr'         => 'row',
        'tbody'      => 'tbody',
        'thead'      => 'thead',
        'u'          => 'emphasis',
        'ul'         => 'itemizedlist',
    );

    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $element->setProperty( 
            'type',
            $this->nameMapping[$element->tagName]
        );
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
        return isset( $this->nameMapping[$element->tagName] );
    }
}

?>

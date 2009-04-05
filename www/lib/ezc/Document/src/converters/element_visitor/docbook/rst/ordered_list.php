<?php
/**
 * File containing the ordered list handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit itemized list / bullet lists
 *
 * Visit itemized lists (bullet list) and maintain the correct indentation for
 * list items.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToRstOrderedListHandler extends ezcDocumentDocbookToRstBaseHandler
{
    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        ezcDocumentDocbookToRstConverter::$indentation += 3;

        foreach ( $node->childNodes as $child )
        {
            if ( ( $child->nodeType === XML_ELEMENT_NODE ) &&
                 ( $child->tagName === 'listitem' ) )
            {
                $root .= str_repeat( ' ', ezcDocumentDocbookToRstConverter::$indentation - 3 ) . '#) ' .
                    trim( $converter->visitChildren( $child, '' ) ) . "\n\n";
            }
        }

        ezcDocumentDocbookToRstConverter::$indentation -= 3;
        return $root;
    }
}

?>

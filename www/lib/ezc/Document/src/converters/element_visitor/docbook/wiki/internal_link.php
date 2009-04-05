<?php
/**
 * File containing the internal link handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit internal links. 
 *
 * Internal links are transformed into local links in HTML, where the name
 * of the target is prefixed with a number sign.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToWikiInternalLinkHandler extends ezcDocumentDocbookToWikiBaseHandler
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
        $root .= ' `' . $converter->visitChildren( $node, '' ) . '`__';
        $converter->appendLink( $node->getAttribute( 'linked' ) . '_' );
        return $root;
    }
}

?>

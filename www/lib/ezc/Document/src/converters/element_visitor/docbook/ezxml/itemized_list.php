<?php
/**
 * File containing the itemized list handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit itemized lists
 *
 * Visit itemized lists as 'ul' nodes and embed them into another paragraph,
 * which is enforced by eZXml.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToEzXmlItemizedListHandler extends ezcDocumentElementVisitorHandler
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
        $paragraph = $root->ownerDocument->createElement( 'paragraph' );
        $root->appendChild( $paragraph );

        $list = $root->ownerDocument->createElement( 'ul' );
        $paragraph->appendChild( $list );

        $converter->visitChildren( $node, $list );
        return $root;
    }
}

?>

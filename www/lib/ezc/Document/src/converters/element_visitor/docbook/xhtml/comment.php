<?php
/**
 * File containing the comment handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit docbook comment
 *
 * Transform docbook comments into HTML ( / XML ) comments.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToHtmlCommentHandler extends ezcDocumentDocbookToHtmlBaseHandler
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
        $comment = new DOMComment( htmlspecialchars( $node->textContent ) );
        $root->appendChild( $comment );

        return $root;
    }
}

?>

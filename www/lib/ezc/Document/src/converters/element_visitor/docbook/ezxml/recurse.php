<?php
/**
 * File containing the recursing handler ignoring the current nodes markup
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for elements, which are self to ignore itself, and just should rbe
 * recursed into.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToEzXmlRecurseHandler extends ezcDocumentElementVisitorHandler
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
        return $converter->visitChildren( $node, $root );
    }
}

?>

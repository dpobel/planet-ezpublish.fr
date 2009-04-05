<?php
/**
 * File containing the footnote handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit footnotes
 *
 * Footnotes in docbook are emebdded at the position, the reference should
 * occur. We store the contents, to be rendered at the end of the HTML
 * document, and only render a number referencing the actual footnote at
 * the position of the footnote in the docbook document.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToRstFootnoteHandler extends ezcDocumentDocbookToRstBaseHandler
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
        $footnoteContent = trim( $converter->visitChildren( $node, '' ) );
        $number = $converter->appendFootnote( $footnoteContent );

        // Add autonumbered footnote reference
        $root .= '[#]_ ';

        return $root;
    }
}

?>

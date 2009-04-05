<?php
/**
 * File containing the ezcDocumentWikiCodePlugin class
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for wiki directives
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentWikiCodePlugin extends ezcDocumentWikiPlugin
{
    /**
     * Transform directive to docbook
     *
     * Create a docbook XML structure at the directives position in the
     * document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $code = $document->createElement( 'literallayout', $this->node->text );
        $root->appendChild( $code );

        if ( isset( $this->node->parameters[0] ) )
        {
            $code->setAttribute( 'language', $this->node->parameters[0] );
        }
    }
}

?>

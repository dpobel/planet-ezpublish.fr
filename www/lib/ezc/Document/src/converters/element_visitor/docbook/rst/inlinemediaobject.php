<?php
/**
 * File containing the inline media object handler
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit inline media objects
 *
 * Inline media objects are all kind of other media types, embedded in
 * paragraphs, like images.
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentDocbookToRstInlineMediaObjectHandler extends ezcDocumentDocbookToRstMediaObjectHandler
{
    /**
     * Substitution counter.
     * 
     * @var int
     */
    protected $substitution = 0;

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
        $directive = $this->getDirectiveParameters( $converter, $node );
        $converter->appendDirective( $this->renderDirective(
            '|' . ( $name = $directive['type'] . '_' . ++$this->substitution ) . '| ' . $directive['type'],
            $directive['parameter'],
            $directive['options'],
            $directive['content']
        ) );

        $root .= "|$name|";
        
        return $root;
    }
}

?>

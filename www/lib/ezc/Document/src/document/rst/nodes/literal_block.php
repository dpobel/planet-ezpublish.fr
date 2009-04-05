<?php
/**
 * File containing the ezcDocumentRstLiteralBlockNode struct
 *
 * @package DocumentBlock
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The literal block AST node
 * 
 * @package DocumentBlock
 * @version 1.1.1
 * @access private
 */
class ezcDocumentRstLiteralBlockNode extends ezcDocumentRstBlockNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @param array $nodes
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, array $nodes = array() )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::LITERAL_BLOCK );
        $this->nodes = $nodes;
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return 'CDATA';
    }

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $node = new ezcDocumentRstLiteralBlockNode(
            $properties['token'],
            $properties['nodes']
        );

        $node->indentation = isset( $properties['indentation'] ) ? $properties['indentation'] : 0;
        return $node;
    }
}

?>

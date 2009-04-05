<?php
/**
 * File containing the ezcTemplateOutputAstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a node that should be sent to the output.
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateOutputAstNode extends ezcTemplateAstNode
{
    /**
     * The expression that should be output. 
     *
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Whether the output should be sent as raw (no context escaping).
     *
     * @var bool
     */
    public $isRaw;

    /**
     * Constructs a new output node.
     *
     * @param ezcTemplateAstNode $expression
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
?>

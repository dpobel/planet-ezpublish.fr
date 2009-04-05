<?php
/**
 * File containing the ezcTemplateArrayAppendOperatorAstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Represents the PHP array append operator []
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateArrayAppendOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Initialize operator code constructor with 1 parameter (unary).
     *
     * @param ezcTemplateAstNode $parameter 
     */
    public function __construct( ezcTemplateAstNode $parameter = null )
    {
        parent::__construct( self::OPERATOR_TYPE_UNARY, false );
        if ( $parameter )
        {
            $this->appendParameter( $parameter );
        }
    }

    /**
     * Returns a text string representing the PHP operator.
     *
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '[]';
    }
}
?>

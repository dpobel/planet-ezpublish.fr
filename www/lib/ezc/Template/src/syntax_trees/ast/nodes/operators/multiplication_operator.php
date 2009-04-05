<?php
/**
 * File containing the ezcTemplateMultiplicationOperatorAstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents the PHP multiplication operator *
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateMultiplicationOperatorAstNode extends ezcTemplateBinaryOperatorAstNode
{
    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '*';
    }
}
?>

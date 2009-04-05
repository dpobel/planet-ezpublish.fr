<?php
/**
 * File containing the ezcTemplateVariableTstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Variable referal in an expression.
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateVariableTstNode extends ezcTemplateExpressionTstNode
{

    /**
     * Name of the variable which is referred.
     *
     * @var string
     */
    public $name;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->name = false;
    }

    public function getTreeProperties()
    {
        return array( 'name' => $this->name );
    }
}
?>

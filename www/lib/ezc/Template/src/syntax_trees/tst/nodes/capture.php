<?php
/**
 * File containing the ezcTemplateCaptureTstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateCaptureTstNode extends ezcTemplateBlockTstNode
{
    public $variable;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end)
    {
        parent::__construct( $source, $start, $end );
        $this->isNestingBlock = true;
    }

    public function getTreeProperties()
    {
        return array( 'variable'  => $this->variable,
                      'children'  => $this->children );
    }
    
}
?>

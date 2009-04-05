<?php
/**
 * File containing the abstract ezcDocumentRstMarkupNode struct
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The abstract inline markup base AST node
 * 
 * @package Document
 * @version 1.1.1
 * @access private
 */
abstract class ezcDocumentRstMarkupNode extends ezcDocumentRstNode
{
    /**
     * Indicator wheather this is an open or closing tag.
     * 
     * @var bool
     */
    public $openTag;
}

?>

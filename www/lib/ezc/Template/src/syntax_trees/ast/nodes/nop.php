<?php
/**
 * File containing the ezcTemplateNopAstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a PHP code which does nothing.
 * This is typically used to null out existing PHP code.
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateNopAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Constructs a new NOP instruction.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
?>

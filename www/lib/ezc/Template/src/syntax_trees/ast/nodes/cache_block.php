<?php
/**
 * File containing the ezcTemplateCacheBlockAstNode class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The nodes under the cacheBlock are supposed to be cached.
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateCacheBlockAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The body node inside this cache block.
     *
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->body = $body;
    }
}

?>

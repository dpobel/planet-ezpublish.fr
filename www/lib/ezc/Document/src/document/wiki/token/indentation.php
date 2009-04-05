<?php
/**
 * File containing the ezcDocumentWikiParagraphIndentationToken struct
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document paragraph indentation tokens
 * 
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentWikiParagraphIndentationToken extends ezcDocumentWikiLineMarkupToken
{
    /**
     * Level of paragraph indentation.
     * 
     * @var int
     */
    public $level = 0;

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $tokenClass = __CLASS__;
        $token = new $tokenClass(
            $properties['content'],
            $properties['line'],
            $properties['position']
        );

        // Set additional token values
        $token->level = $properties['level'];

        return $token;
    }
}

?>

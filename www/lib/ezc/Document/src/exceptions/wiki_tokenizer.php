<?php
/**
 * Wiki tokenizer exception
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when the Wiki tokenizer could not tokenize a character
 * sequence.
 *
 * This should never been thrown, but it is hard to prove that there is nothing
 * which is not matched by the regualr expressions above.
 *
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentWikiTokenizerException extends ezcDocumentException
{
    /**
     * Construct exception from errnous string and current position
     * 
     * @param int $line 
     * @param int $position 
     * @param string $string 
     * @return void
     */
    public function __construct( $line, $position, $string )
    {
        parent::__construct( 
            "Could not tokenize string at line {$line} char {$position}: '" . substr( $string, 0, 10 ) . "'."
        );
    }
}

?>

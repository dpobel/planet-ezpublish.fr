<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.2
 * @filesource
 * @package Translation
 */

/**
 * Thrown when the translation file does not exist.
 *
 * @package Translation
 * @version 1.2
 */
class ezcTranslationMissingTranslationFileException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationMissingTranslationFileException.
     *
     * @param string $fileName
     * @return void
     */
    function __construct( $fileName )
    {
        parent::__construct( "The translation file '{$fileName}' does not exist." );
    }
}
?>

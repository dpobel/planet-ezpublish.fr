<?php
/**
 * Document parser exception
 *
 * @package Document
 * @version 1.1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when the RST parser could not parse asome token sequence.
 *
 * @package Document
 * @version 1.1.1
 */
class ezcDocumentParserException extends ezcDocumentConversionException
{
    /**
     * Error string
     *
     * String describing the general type of this error
     * 
     * @var string
     */
    protected $errorString = 'Parse error';
}

?>

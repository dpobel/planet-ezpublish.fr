<?php
/**
 * File containing the ezcMvcInvalidEncodingException class.
 *
 * @package MvcTools
 * @version 1.0
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the recode filter detects an invalid input encoding.
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcInvalidEncodingException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcInvalidEncodingException
     *
     * @param string $string
     * @param string $encoding
     */
    public function __construct( $string, $encoding )
    {
        parent::__construct( "The string '$string' is invalid in character set '$encoding'." );
    }
}
?>

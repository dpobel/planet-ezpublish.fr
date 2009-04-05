<?php
/**
 * File containing the ezcTemplateFileNotWriteableException class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception for problems when writing to template files.
 *
 * @package Template
 * @version 1.3.2
 */
class ezcTemplateFileNotWriteableException extends ezcTemplateException
{
    /**
     * Constructor
     *
     * @param string $stream    The stream path to the template file which could not be written.
     * @param string $type      The type of the file that could not be read.
     */
    public function __construct( $stream, $type = "requested template file" )
    {
        parent::__construct( "The {$type} '{$stream}' is not writeable." );
    }
}
?>

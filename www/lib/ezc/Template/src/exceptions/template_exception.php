<?php
/**
 * File containing the ezcTemplateException class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcTemplateExceptions are thrown when an exceptional state
 * occurs in the Template package.
 *
 * @package Template
 * @version 1.3.2
 */
class ezcTemplateException extends ezcBaseException
{
    /**
     * Constructs a new ezcTemplateException with error message $message.
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

<?php
/**
 * File containing the ezcTemplateInternalException class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcTemplateInternalException is thrown when the Template engine comes into
 * an unstable state.
 *
 * @package Template
 * @version 1.3.2
 */
class ezcTemplateInternalException extends ezcTemplateException
{
    /**
     * Creates a template internal exception.
     *
     * @param string $msg
     */
    public function __construct( $msg )
    {
        parent::__construct( "Internal error: $msg" );
    }
}
?>

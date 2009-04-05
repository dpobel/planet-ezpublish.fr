<?php
/**
 * File containing the ezcMvcFilterHasNoOptionsException class.
 *
 * @package MvcTools
 * @version 1.0
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when filter options are set, but the filter doesn't
 * support options.
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcFilterHasNoOptionsException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcFilterHasNoOptionsException
     *
     * @param string $filterClass
     */
    public function __construct( $filterClass )
    {
        parent::__construct( "The filter '$filterClass' does not support options." );
    }
}
?>

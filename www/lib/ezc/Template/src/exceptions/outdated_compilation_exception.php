<?php
/**
 * File containing the ezcTemplateOutdatedCompilationException class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcTemplateOutdatedCompilationException is thrown internally to signal that
 * the current template is expired. 
 *
 * @package Template
 * @version 1.3.2
 * @access private
 */
class ezcTemplateOutdatedCompilationException extends ezcTemplateException
{
    /**
     * Creates a exception for outdated compilations, error message is
     * specified by caller.
     *
     * @param string $msg
     */
    public function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.0
 * @filesource
 * @package MvcTools
 */

/**
 * A response filter is responsible for altering the response object.
 * 
 * @package MvcTools
 * @version 1.0
 */
interface ezcMvcResponseFilter
{
    /**
     * Alters the response object.
     * 
     * @param ezcMvcResponse $response Response object to alter.
     */
    public function filterResponse( ezcMvcResponse $response );

    /**
     * Sets options on the filter object
     *
     * @throws ezcMvcFilterHasNoOptionsException if the filter does not support options.
     * @param array $options
     */
    public function setOptions( array $options );
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.0
 * @filesource
 * @package MvcTools
 */

/**
 * A request filter is responsible for altering the request object.
 * 
 * @package MvcTools
 * @version 1.0
 */
interface ezcMvcRequestFilter
{
    /**
     * Alters the request object.
     * 
     * @param ezcMvcRequest $request Request object to alter.
     */
    public function filterRequest( ezcMvcRequest $request );

    /**
     * Sets options on the filter object
     *
     * @throws ezcMvcFilterHasNoOptionsException if the filter does not support options.
     * @param array $options
     */
    public function setOptions( array $options );
}
?>

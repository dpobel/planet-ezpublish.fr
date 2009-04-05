<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.0
 * @filesource
 * @package MvcTools
 */

/**
 * Abstract class defining a response writer.
 *
 * A response writer takes an ezcMvcResponse object and sends the response back
 * to the client after preparing it for this specific medium.
 *
 * @package MvcTools
 * @version 1.0
 */
abstract class ezcMvcResponseWriter
{
    /**
     * Creates a new response writer object
     *
     * @param ezcMvcResponse $response
     */
    abstract public function __construct( ezcMvcResponse $response );

    /**
     * Takes the raw protocol depending response body, and the protocol
     * abstract response headers and forges a response to the client. Then it sends
     * the assembled response to the client.
     */
    abstract public function handleResponse();
}
?>

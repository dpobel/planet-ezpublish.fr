<?php
/**
 * File containing the ezpRestHttpResponseWriter class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

class ezpRestHttpResponseWriter extends ezcMvcHttpResponseWriter
{
    /**
     * The response struct object.
     *
     * In the ezp rest version this variable is public, so that error messages
     * can be injected into the response body.
     *
     * @var ezcMvcResponse
     */
    public $response;

}

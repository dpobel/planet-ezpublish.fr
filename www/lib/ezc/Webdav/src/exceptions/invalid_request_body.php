<?php
/**
 * File containing the ezcWebdavInvalidRequestBodyException class.
 * 
 * @package Webdav
 * @version 1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Thrown if the request body received was invalid.
 * 
 * @package Webdav
 * @version 1.1
 */
class ezcWebdavInvalidRequestBodyException extends ezcWebdavBadRequestException
{
    /**
     * Initializes the exception with the given $method and $reason and sets
     * the exception message from it.
     * 
     * @param mixed $method 
     * @param mixed $reason 
     * @return void
     */
    public function __construct( $method, $reason = null )
    {
        parent::__construct(
            "The HTTP request body received for HTTP method '$method' was invalid." . ( $reason !== null ? " Reason: $reason" : '' )
        );
    }
}

?>

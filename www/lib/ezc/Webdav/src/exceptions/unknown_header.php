<?php
/**
 * File containing the ezcWebdavUnknownHeaderException class.
 *
 * @package Webdav
 * @version 1.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a header to parse is unknown.
 * There seems to be no way to determine headers by their original name in PHP,
 * but only through the keys HTTP_* in $_SERVER. Therefore, the header must be
 * known by {@ezcWebdavTransport->parseHeaders()} to get assigned properly.
 * 
 * @package Webdav
 * @version 1.1
 */
class ezcWebdavUnknownHeaderException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $header and sets the exception
     * message from it.
     * 
     * @param string $headerName    Name of the affected header.
     * @return void
     */
    public function __construct( $headerName )
    {
        parent::__construct( "The header '$headerName' has no equivalent in the header map." );
    }
}



?>

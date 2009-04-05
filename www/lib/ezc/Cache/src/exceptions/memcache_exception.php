<?php
/**
 * File containing the ezcCacheMemcacheException class.
 *
 * @package Cache
 * @version 1.4
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when encountering an error in the Memcache backend.
 *
 * @package Cache
 * @version 1.4
 */
class ezcCacheMemcacheException extends ezcBaseException
{
    /**
     * Creates a new ezcCacheMemcacheException.
     * 
     * @param mixed $message The message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

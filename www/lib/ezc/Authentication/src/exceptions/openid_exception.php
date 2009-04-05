<?php
/**
 * File containing the ezcAuthenticationOpenidException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version 1.2.3
 */

/**
 * Thrown when an exceptional state occurs in the OpenID authentication.
 *
 * @package Authentication
 * @version 1.2.3
 */
class ezcAuthenticationOpenidException extends ezcAuthenticationException
{
    /**
     * Constructs a new ezcAuthenticationOpenidException with error message
     * $message.
     *
     * @param string $message Message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

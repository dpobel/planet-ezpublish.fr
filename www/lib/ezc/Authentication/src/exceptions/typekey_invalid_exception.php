<?php
/**
 * File containing the ezcAuthenticationTypekeyPublicKeysInvalidException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version 1.2.3
 */

/**
 * Thrown the public keys file contained invalid data in TypeKey authentication.
 *
 * @package Authentication
 * @version 1.2.3
 */
class ezcAuthenticationTypekeyPublicKeysInvalidException extends ezcAuthenticationTypekeyException
{
    /**
     * Constructs a new ezcAuthenticationTypekeyPublicKeysInvalidException
     * with error message $message.
     *
     * @param string $message Message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

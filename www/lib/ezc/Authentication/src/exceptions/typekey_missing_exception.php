<?php
/**
 * File containing the ezcAuthenticationTypekeyPublicKeysMissingException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version 1.2.3
 */

/**
 * Thrown the public keys file could not be accessed in TypeKey authentication.
 *
 * @package Authentication
 * @version 1.2.3
 */
class ezcAuthenticationTypekeyPublicKeysMissingException extends ezcAuthenticationTypekeyException
{
    /**
     * Constructs a new ezcAuthenticationTypekeyPublicKeysMissingException
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

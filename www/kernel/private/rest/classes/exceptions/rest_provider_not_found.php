<?php
/**
 * File containing the ezpRestProviderNotfoundException class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

class ezpRestProviderNotFoundException extends ezpRestException
{
    public function __construct( $providerName )
    {
        parent::__construct( "The API provider '{$providerName}' could not be found." );
    }
}

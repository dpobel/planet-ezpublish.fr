<?php
/**
 * File containing the ezpOauthException class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/**
 * This is the base exception for the eZ Publish oauth library.
 *
 * @package oauth
 */
abstract class ezpOauthException extends ezcBaseException
{
    public $errorType = null;
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

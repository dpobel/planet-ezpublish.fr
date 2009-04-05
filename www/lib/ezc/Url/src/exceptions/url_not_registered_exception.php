<?php
/**
 * File containing the ezcUrlNotRegisteredException class
 *
 * @package Url
 * @version 1.2.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcUrlNotRegisteredException is thrown whenever you try to use a url
 * that is not registered.
 *
 * @package Url
 * @version 1.2.2
 */
class ezcUrlNotRegisteredException extends ezcUrlException
{
    /**
     * Constructs a new ezcUrlNotRegisteredException.
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        $message = "The url '{$name}' is not registered.";
        parent::__construct( $message );
    }
}
?>

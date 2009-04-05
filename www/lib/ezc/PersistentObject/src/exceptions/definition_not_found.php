<?php
/**
 * File containing the ezcPersistentObjectException class
 *
 * @package PersistentObject
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * General exception class for the PersistentObject package.
 *
 * All exceptions in the persistent object package are derived from this exception.
 *
 * @package PersistentObject
 * @version 1.5
 */
class ezcPersistentDefinitionNotFoundException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentDefinitionNotFoundException for the class $class
     * with the additional error information $message.
     *
     * @param string $class
     * @param string $message
     * @return void
     */
    public function __construct( $class, $message = null )
    {
        $info = "Could not fetch the persistent object definition for the class '$class'.";
        if ( $message !== null )
        {
            $info .= " {$message}";
        }
        parent::__construct( $info );
    }
}
?>

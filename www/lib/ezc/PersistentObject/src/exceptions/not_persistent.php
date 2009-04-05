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
 * Exception thrown when a method that requires a persistent object is provided
 * an object not yet persistent.
 *
 * @package PersistentObject
 * @version 1.5
 */
class ezcPersistentObjectNotPersistentException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentObjectNotPersistentException for the class
     * $class.
     *
     * @param string $class
     * @return void
     */
    public function __construct( $class )
    {
        parent::__construct( "The object of type $class is not persistent." );
    }
}
?>

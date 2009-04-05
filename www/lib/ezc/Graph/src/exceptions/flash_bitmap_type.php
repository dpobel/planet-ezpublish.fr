<?php
/**
 * File containing the ezcGraphFlashBitmapTypeException class
 *
 * @package Graph
 * @version 1.4.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Flash can only embed JPEGs and PNGs. This exception is thrown for * all
 * other image types.
 *
 * @package Graph
 * @version 1.4.1
 */
class ezcGraphFlashBitmapTypeException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @return void
     * @ignore
     */
    public function __construct()
    {
        parent::__construct( "Flash can only read JPEGs and PNGs." );
    }
}

?>

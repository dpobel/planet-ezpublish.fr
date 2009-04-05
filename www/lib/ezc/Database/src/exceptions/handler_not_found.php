<?php
/**
 * File containing the ezcDbException class.
 *
 * @package Database
 * @version 1.4.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exceptions is used when a database handler could not be found.
 *
 * @package Database
 * @version 1.4.3
 */
class ezcDbHandlerNotFoundException extends ezcDbException
{
    /**
     * Constructs a new exception.
     *
     * $name specifies the name of the name of the handler to use.
     * $known is a list of the known database handlers.
     *
     * @param string $name
     * @param array(string) $known
     */
    public function __construct( $name, array $known = array() )
    {
        if ( $name == '' || $name == null )
        {
            $name = 'no name provided';
        }
        $message = "Could not find the database handler: '{$name}'.";

        if ( count( $known ) > 0 )
        {
            $knownMessage = ' The known databases are: ' . implode( ', ', $known ) . '.';
            $message .= $knownMessage;
        }
        parent::__construct( $message );
    }
}
?>

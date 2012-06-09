<?php
/**
 * File containing the eZDFSFileHandlerTableNotFoundException class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/**
 * Class handling a cluster table not found exception
 *
 * @version  2012.5
 * @package kernel
 */

class eZDFSFileHandlerTableNotFoundException extends ezcBaseException
{
    /**
     * Constructs a new eZDFSFileHandlerTableNotFoundException
     *
     * @param string $sql The SQL query
     * @param string $error The SQL error message
     * @return void
     */
    function __construct( $sql, $error )
    {
        $message = "Table not found when executing SQL '$sql' ".
                   "(error message: $error).\n" .
                   "Please review the cluster tables installation or configuration";
        parent::__construct( $message );
    }
}
?>

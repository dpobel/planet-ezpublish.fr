<?php
/**
 * File containing the ezcArchiveBlockSizeException class.
 *
 * @package Archive
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception will be thrown when the block-size of an archive is invalid.
 *
 * @package Archive
 * @version 1.3.2
 */
class ezcArchiveBlockSizeException extends ezcArchiveException
{
    /**
     * Constructs a new block-size exception for the specified archive.
     *
     * @param string $archiveName
     * @param string $msg
     */
    public function __construct( $archiveName, $msg = null )
    {
        $default = "The archive '{$archiveName}' has an invalid block size.";

        if ( $msg !== null )
        {
            $default .= " {$msg}";
        }

        parent::__construct( $default );
    }
}
?>

<?php
/**
 * File containing the eZClusterEventLogger class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 */

/**
 * Interface for eZClusterEvent loggers.
 *
 * Cluster events can be used either inside eZ Publish (cache read/write, file handling...), but also
 * through index_cluster.php in order to serve binary files.
 * In the last case, the process should be as fast as possible and consume less resources as possible.
 * Thus we should not include heavy dependencies on eZ Publish utility classes like eZDebug in order to log errors.
 * This interface is to be implemented by classes dedicated to error logging, depending on context.
 */
interface eZClusterEventLogger
{
    /**
     * Logs $errMsg.
     *
     * @param string $errMsg Error message to be logged
     * @param string $context Context where the error occurred
     * @return void
     */
    public function logError( $errMsg, $context = null );
}

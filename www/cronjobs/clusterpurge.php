<?php
/**
 * Cluster files purge cronjob
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

if ( !eZScriptClusterPurge::isRequired() )
{
    $cli->error( "Your current cluster handler does not require file purge" );
    $script->shutdown( 1 );
}

$purgeHandler = new eZScriptClusterPurge();
$purgeHandler->optScopes = array( 'classattridentifiers',
                                  'classidentifiers',
                                  'content',
                                  'expirycache',
                                  'statelimitations',
                                  'template-block',
                                  'user-info-cache',
                                  'viewcache',
                                  'wildcard-cache-index',
                                  'image',
                                  'media',
                                  'binaryfile' );
$purgeHandler->optExpiry = 30;
$purgeHandler->run();

?>

<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$Module = $Params['Module'];
$http = eZHTTPTool::instance();
$orderIDArray = $http->sessionVariable( "OrderIDArray" );

$db = eZDB::instance();
$db->begin();
foreach ( $orderIDArray as $archiveID )
{
    eZOrder::unarchiveOrder( $archiveID );
}
$db->commit();
$Module->redirectTo( '/shop/archivelist/' );
?>

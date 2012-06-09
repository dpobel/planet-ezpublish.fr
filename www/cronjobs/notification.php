<?php
/**
 * File containing the notification.php cronjob
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$event = eZNotificationEvent::create( 'ezcurrenttime', array() );

$event->store();
$cli->output( "Starting notification event processing" );
eZNotificationEventFilter::process();

$cli->output( "Done" );

?>

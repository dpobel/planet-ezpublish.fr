<?php
//
// Definition of Basket_cleanup class
//
// Created on: <14-Jun-2005 14:44:49 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

/*! \file basket_cleanup.php
*/

//include_once( 'lib/ezutils/classes/ezini.php' );

$ini = eZINI::instance();

// Check if this should be run in a cronjob
$useCronjob = $ini->variable( 'Session', 'BasketCleanup' ) == 'cronjob';
if ( !$useCronjob )
    return;

// Only do basket cleanup once in a while
$freq = $ini->variable( 'Session', 'BasketCleanupAverageFrequency' );
if ( mt_rand( 1, max( $freq, 1 ) ) != 1 )
    return;

//include_once( 'kernel/classes/ezbasket.php' );
//include_once( 'kernel/classes/ezdbgarbagecollector.php' );

$maxTime = $ini->variable( 'Session', 'BasketCleanupTime' );
$idleTime = $ini->variable( 'Session', 'BasketCleanupIdleTime' );
$fetchLimit = $ini->variable( 'Session', 'BasketCleanupFetchLimit' );

if ( !$isQuiet )
    $cli->output( "Cleaning up expired baskets" );
eZDBGarbageCollector::collectBaskets( $maxTime, $idleTime, $fetchLimit );

?>

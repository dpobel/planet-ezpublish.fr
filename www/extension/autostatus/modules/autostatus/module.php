<?php
/**
 * SOFTWARE NAME: autostatus
 * SOFTWARE RELEASE: 0.2
 * COPYRIGHT NOTICE: Copyright (C) 2009-2011 Damien POBEL
 * SOFTWARE LICENSE: GNU General Public License v2.0
 * NOTICE: >
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of version 2.0  of the GNU General
 *   Public License as published by the Free Software Foundation.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of version 2.0 of the GNU General
 *   Public License along with this program; if not, write to the Free
 *   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *   MA 02110-1301, USA.
 */

$Module = array( 'name' => 'Autostatus' );

$ViewList = array();
$ViewList['log'] = array( 'script' => 'log.php',
                          'functions' => array( 'log' ),
                          'default_navigation_part' => 'autostatus',
                          'ui_context' => 'view',
                          'params' => array( 'Error' ),
                          'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['oauth'] = array( 'script' => 'oauth.php',
                            'functions' => array( 'oauth' ),
                            'default_navigation_part' => 'autostatus',
                            'ui_context' => 'view',
                            'params' => array( 'Network', 'WorkflowEventID' ),
                            'unordered_params' => array() );

$FunctionList = array();
$FunctionList['log'] = array();
$FunctionList['oauth'] = array();

?>

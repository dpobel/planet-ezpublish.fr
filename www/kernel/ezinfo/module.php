<?php
//
// Created on: <17-Apr-2002 11:05:08 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.1.0
// BUILD VERSION: 23234
// COPYRIGHT NOTICE: Copyright (C) 1999-2009 eZ Systems AS
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

$Module = array( "name" => "eZInfo",
                 "variable_params" => true );

$ViewList = array();
$ViewList["copyright"] = array(
    "functions" => array( 'read' ),
    "script" => "copyright.php",
    "params" => array() );

$ViewList["about"] = array(
    "functions" => array( 'read' ),
    "script" => "about.php",
    "params" => array() );

$ViewList["is_alive"] = array(
    "functions" => array( 'read' ),
    "script" => "isalive.php",
    "params" => array() );

$FunctionList = array();
$FunctionList['read'] = array();

?>

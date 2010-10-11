<?php
//
// Definition of Pendinglist class
//
// Created on: <06-Aug-2003 13:36:08 wy>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.3.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
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
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file
*/


$Module = $Params['Module'];
$http = eZHTTPTool::instance();

$Offset = $Params['Offset'];
$viewParameters = array( 'offset' => $Offset );

$user = eZUser::currentUser();
$userID = $user->id();


$tpl = eZTemplate::factory();
$tpl->setVariable('view_parameters', $viewParameters );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:content/pendinglist.tpl' );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'My pending list' ),
                                'url' => false ) );
?>

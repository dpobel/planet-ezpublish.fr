<?php
//
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

$Module = $Params['Module'];
$Module->setTitle( "Successful registration" );
// Template handling

$tpl = eZTemplate::factory();
$tpl->setVariable( "module", $Module );
$ini = eZINI::instance();
$verifyUserEmail = $ini->variable( 'UserSettings', 'VerifyUserEmail' );
if ( $verifyUserEmail == "enabled" )
    $tpl->setVariable( "verify_user_email", true );
else
    $tpl->setVariable( "verify_user_email", false );

$Result = array();
$Result['content'] = $tpl->fetch( "design:user/success.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/user', 'User' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/user', 'Success' ),
                                'url' => false ) );
if ( $ini->variable( 'SiteSettings', 'LoginPage' ) == 'custom' )
    $Result['pagelayout'] = 'loginpagelayout.tpl';

?>

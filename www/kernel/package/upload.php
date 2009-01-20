<?php
//
// Created on: <11-Aug-2003 18:12:39 amos>
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

require_once( "kernel/common/template.php" );
//include_once( "kernel/classes/ezpackage.php" );
//include_once( "lib/ezutils/classes/ezhttpfile.php" );

$module = $Params['Module'];

if ( !eZPackage::canUsePolicyFunction( 'import' ) )
    return $module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );

$package = false;
$installElements = false;
$errorList = array();

if ( $module->isCurrentAction( 'UploadPackage' ) )
{
    if ( eZHTTPFile::canFetch( 'PackageBinaryFile' ) )
    {
        $file = eZHTTPFile::fetch( 'PackageBinaryFile' );
        if ( $file )
        {
            $packageFilename = $file->attribute( 'filename' );
            $packageName = $file->attribute( 'original_filename' );
            if ( preg_match( "#^(.+)-[0-9](\.[0-9]+)-[0-9].ezpkg$#", $packageName, $matches ) )
                $packageName = $matches[1];
            $packageName = preg_replace( array( "#[^a-zA-Z0-9]+#",
                                                "#_+#",
                                                "#(^_)|(_$)#" ),
                                         array( '_',
                                                '_',
                                                '' ), $packageName );
            $package =& eZPackage::import( $packageFilename, $packageName );
            if ( is_object( $package ) )
            {
                if ( $package->attribute( 'install_type' ) != 'install' or
                     !$package->attribute( 'can_install' ) )
                {
                    return $module->redirectToView( 'view', array( 'full', $package->attribute( 'name' ) ) );
                }
                else if ( $package->attribute( 'install_type' ) == 'install' )
                {
                    return $module->redirectToView( 'install', array( $package->attribute( 'name' ) ) );
                }
            }
            else if ( $package == eZPackage::STATUS_ALREADY_EXISTS )
            {
                $errorList[] = array( 'description' => ezi18n( 'kernel/package', 'Package %packagename already exists, cannot import the package', false, array( '%packagename' => $packageName ) ) );
            }
            else
            {
                eZDebug::writeError( "Uploaded file is not an eZ Publish package" );
            }
        }
        else
        {
            eZDebug::writeError( "Failed fetching upload package file" );
        }
    }
    else
    {
        eZDebug::writeError( "No uploaded package file was found" );
    }
}
else if ( $module->isCurrentAction( 'UploadCancel' ) )
{
    $module->redirectToView( 'list' );
    return;
}

$tpl = templateInit();

$tpl->setVariable( 'package', $package );
$tpl->setVariable( 'error_list', $errorList );

$Result = array();
$Result['content'] = $tpl->fetch( "design:package/upload.tpl" );
$Result['path'] = array( array( 'url' => 'package/list',
                                'text' => ezi18n( 'kernel/package', 'Packages' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'kernel/package', 'Upload' ) ) );

?>

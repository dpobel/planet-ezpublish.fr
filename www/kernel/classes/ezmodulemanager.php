<?php
//
// Definition of eZModuleManager class
//
// Created on: <19-Aug-2002 16:37:56 sp>
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

/*! \file ezmodulemanager.php
*/

/*!
  \class eZModuleManager ezmodulemanager.php
  \brief The class eZModuleManager does

*/

class eZModuleManager
{
    static function aviableModules()
    {
        eZDebug::writeWarning( 'The function eZModuleManager::aviableModules is deprecated, use eZModuleManager::availableModules instead' );
        return eZModuleManager::availableModules();
    }

    static function availableModules()
    {
        //include_once( 'lib/ezutils/classes/ezmodule.php' );
        $pathList = eZModule::globalPathList();
        $modules = array();
        foreach ( $pathList as $pathItem )
        {
            if ( $handle = opendir( $pathItem ) )
            {
                while ( false !== ( $file = readdir( $handle ) ) )
                {
                    if ( is_dir( $pathItem . '/' . $file ) && file_exists( $pathItem . '/' . $file . '/module.php' )  )
                    {
                        $modules[] = $file;
                    }
                }
                closedir( $handle );
            }
        }
        return $modules;
    }
}

?>

<?php
//
// Definition of eZExtensionPackageHandler class
//
// Created on: <15-Dec-2005 11:15:42 ks>
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

/*! \file
*/

/*!
  \class eZExtensionPackageHandler ezextensionpackagehandler.php
  \brief Handles extenstions in the package system

*/

class eZExtensionPackageHandler extends eZPackageHandler
{
    const ERROR_EXISTS = 1;

    const ACTION_REPLACE = 1;
    const ACTION_SKIP = 2;

    /*!
     Constructor
    */
    function eZExtensionPackageHandler()
    {
        $this->eZPackageHandler( 'ezextension',
                                 array( 'extract-install-content' => true ) );
    }

    /*!
     Returns an explanation for the extension install item.
    */
    function explainInstallItem( $package, $installItem, $requestedInfo = array() )
    {
        if ( $installItem['filename'] )
        {
            $filename = $installItem['filename'];
            $subdirectory = $installItem['sub-directory'];
            if ( $subdirectory )
                $filepath = $subdirectory . '/' . $filename . '.xml';
            else
                $filepath = $filename . '.xml';

            $filepath = $package->path() . '/' . $filepath;

            $dom = $package->fetchDOMFromFile( $filepath );
            if ( $dom )
            {
                $root = $dom->documentElement;
                $extensionName = $root->getAttribute( 'name' );
                return array( 'description' => ezi18n( 'kernel/package', 'Extension \'%extensionname\'', false,
                                                       array( '%extensionname' => $extensionName ) ) );
            }
        }
    }

    /*!
     Uninstalls extensions.
    */
    function uninstall( $package, $installType, $parameters,
                      $name, $os, $filename, $subdirectory,
                      $content, &$installParameters,
                      &$installData )
    {
        $extensionName = $content->getAttribute( 'name' );

        $siteINI = eZINI::instance();
        $extensionDir = $siteINI->variable( 'ExtensionSettings', 'ExtensionDirectory' ) . '/' . $extensionName;

        // TODO: don't delete modified files?

        if ( file_exists( $extensionDir ) )
            eZDir::recursiveDelete( $extensionDir );

        // Deactivate extension
        $siteINI = eZINI::instance( 'site.ini', 'settings/override', null, null, false, true );
        $selectedExtensions = $siteINI->variable( 'ExtensionSettings', "ActiveExtensions" );

        if ( in_array( $extensionName, $selectedExtensions ) )
        {
            $extensionsFlipped = array_flip( $selectedExtensions );

            $extKey = $extensionsFlipped[$extensionName];
            unset( $selectedExtensions[$extKey] );

            $siteINI->setVariable( "ExtensionSettings", "ActiveExtensions", $selectedExtensions );
            $siteINI->save( 'site.ini.append', '.php', false, false );
        }

        // Regenerate the autoloads to remove of no longer existing classes
        $this->updateAutoload();

        return true;
    }

    /*!
     Copy extension from the package to extension repository.
    */
    function install( $package, $installType, $parameters,
                      $name, $os, $filename, $subdirectory,
                      $content, &$installParameters,
                      &$installData )
    {
        //$this->Package =& $package;

        $trans = eZCharTransform::instance();
        $name = $content->getAttribute( 'name' );
        $extensionName = $trans->transformByGroup( $name, 'urlalias' );
        if ( strcmp( $name, $extensionName ) !== 0 )
        {
            $description = ezi18n( 'kernel/package', 'Package contains an invalid extension name: %extensionname', false, array( '%extensionname' => $name ) );
            $installParameters['error'] = array( 'error_code' => false,
                                                 'element_id' => $name,
                                                 'description' => $description );
            return false;
        }

        $siteINI = eZINI::instance();
        $extensionRootDir = $siteINI->variable( 'ExtensionSettings', 'ExtensionDirectory' );
        $extensionDir = $extensionRootDir . '/' . $extensionName;
        $packageExtensionDir = $package->path() . '/' . $parameters['sub-directory'] . '/' . $extensionName;

        // Error: extension already exists.
        if ( file_exists( $extensionDir ) )
        {
            $description = ezi18n( 'kernel/package', "Extension '%extensionname' already exists.",
                                   false, array( '%extensionname' => $extensionName ) );
            $choosenAction = $this->errorChoosenAction( self::ERROR_EXISTS,
                                                        $installParameters, $description, $this->HandlerType );
            switch( $choosenAction )
            {
            case self::ACTION_SKIP:
                return true;

            case eZPackage::NON_INTERACTIVE:
            case self::ACTION_REPLACE:
                eZDir::recursiveDelete( $extensionDir );
                break;

            default:
                $installParameters['error'] = array( 'error_code' => self::ERROR_EXISTS,
                                                     'element_id' => $extensionName,
                                                     'description' => $description,
                                                     'actions' => array( self::ACTION_REPLACE => ezi18n( 'kernel/package', "Replace extension" ),
                                                                         self::ACTION_SKIP => ezi18n( 'kernel/package', 'Skip' ) ) );
                return false;
            }
        }

        eZDir::mkdir( $extensionDir, false, true );
        eZDir::copy( $packageExtensionDir, $extensionRootDir );

        // Regenerate autoloads for extensions to pick up the newly created extension
        $this->updateAutoload();

        // Activate extension
        $siteINI = eZINI::instance( 'site.ini', 'settings/override', null, null, false, true );

        if ( $siteINI->hasVariable( 'ExtensionSettings', "ActiveExtensions" ) )
        {
            $selectedExtensions = $siteINI->variable( 'ExtensionSettings', "ActiveExtensions" );
        }
        else
        {
            $selectedExtensions = array();
        }

        if ( !in_array( $extensionName, $selectedExtensions ) )
        {
            $selectedExtensions[] = $extensionName;
            $siteINI->setVariable( "ExtensionSettings", "ActiveExtensions", $selectedExtensions );
            $siteINI->save( 'site.ini.append', '.php', false, false );
        }
        return true;
    }

    function add( $packageType, $package, $cli, $parameters )
    {
        foreach ( $parameters as $extensionName )
        {
            $cli->output( 'adding extension ' . $cli->stylize( 'dir', $extensionName ) );
            $this->addExtension( $package, $extensionName );
        }
    }

    static function addExtension( $package, $extensionName )
    {
        $siteINI = eZINI::instance();
        $extensionDir = $siteINI->variable( 'ExtensionSettings', 'ExtensionDirectory' );

        $fileList = array();
        $sourceDir = $extensionDir . '/' . $extensionName;
        $targetDir = $package->path() . '/ezextension';

        eZDir::mkdir( $targetDir, false, true );
        eZDir::copy( $sourceDir, $targetDir );

        eZDir::recursiveList( $targetDir, '', $fileList );

        $doc = new DOMDocument;

        $packageRoot = $doc->createElement( 'extension' );
        $packageRoot->setAttribute( 'name', $extensionName );

        foreach( $fileList as $file )
        {
            $fileNode = $doc->createElement( 'file' );
            $fileNode->setAttribute( 'name', $file['name'] );

            if ( $file['path'] )
                $fileNode->setAttribute( 'path', $file['path'] );

            $fullPath = $targetDir . $file['path'] . '/' . $file['name'];
            $fileNode->setAttribute( 'md5sum', $package->md5sum( $fullPath ) );

            if ( $file['type'] == 'dir' )
                 $fileNode->setAttribute( 'type', 'dir' );

            $packageRoot->appendChild( $fileNode );
            unset( $fileNode );
        }

        $filename = 'extension-' . $extensionName;

        $package->appendInstall( 'ezextension', false, false, true,
                                 $filename, 'ezextension',
                                 array( 'content' => $packageRoot ) );
        $package->appendInstall( 'ezextension', false, false, false,
                                 $filename, 'ezextension',
                                 array( 'content' => false ) );
    }

    function handleAddParameters( $packageType, $package, $cli, $arguments )
    {
        $arguments = array_unique( $arguments );
        $extensionsToAdd = array();

        $siteINI = eZINI::instance();
        $extensionDir = $siteINI->variable( 'ExtensionSettings', 'ExtensionDirectory' );
        $extensionList = eZDir::findSubItems( $extensionDir );

        foreach ( $arguments as $argument )
        {
            if ( in_array( $argument, $extensionList ) )
            {
                $extensionsToAdd[] = $argument;
            }
            else
            {
                $cli->error( 'Extension ' . $cli->style( 'dir' ) . $argument .  $cli->style( 'dir-end' ) . ' not found.' );
                return false;
            }
        }

        return $extensionsToAdd;
    }

    protected function updateAutoload()
    {
        $autoloadGenerator = new eZAutoloadGenerator();
        try
        {
            $autoloadGenerator->buildAutoloadArrays();

            $autoloadWarningMessages = $autoloadGenerator->getWarnings();
            foreach ( $autoloadWarningMessages as $warning )
            {
                eZDebug::writeWarning( $warning, __METHOD__ );
            }
            
            ezpAutoloader::reset();
        }
        catch ( Exception $e )
        {
            eZDebug::writeError( $e->getMessage(), __METHOD__ );
        }
    }

    public $Package = null;
}

?>

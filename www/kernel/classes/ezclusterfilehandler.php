<?php
/**
 * File containing the eZClusterFileHandler class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 4.4.0
 * @package kernel
 */
class eZClusterFileHandler
{
    /**
     * Returns the configured instance of an eZClusterFileHandlerInterface
     * See ClusteringSettings.FileHandler in php.ini
     *
     * @param string|bool $filename
     *        Optional filename the handler should be initialized with
     *
     * @return eZClusterFileHandlerInterface
     */
    static function instance( $filename = false )
    {
        if ( self::$isShutdownFunctionRegistered !== true )
        {
            eZExecution::addCleanupHandler( array( __CLASS__, 'cleanupGeneratingFiles' ) );
            self::$isShutdownFunctionRegistered = true;
        }

        if( $filename !== false )
        {
            $optionArray = array( 'iniFile'      => 'file.ini',
                                  'iniSection'   => 'ClusteringSettings',
                                  'iniVariable'  => 'FileHandler',
                                  'handlerParams'=> array( $filename ) );

            $options = new ezpExtensionOptions( $optionArray );

            $handler = eZExtension::getHandlerClass( $options );

            return $handler;
        }
        else
        {
            // return Filehandler from GLOBALS based on ini setting.
            if ( !isset( $GLOBALS['eZClusterFileHandler_chosen_handler'] ) )
            {
                $optionArray = array( 'iniFile'      => 'file.ini',
                                      'iniSection'   => 'ClusteringSettings',
                                      'iniVariable'  => 'FileHandler' );

                $options = new ezpExtensionOptions( $optionArray );

                $handler = eZExtension::getHandlerClass( $options );

                $GLOBALS['eZClusterFileHandler_chosen_handler'] = $handler;
            }
            else
                $handler = $GLOBALS['eZClusterFileHandler_chosen_handler'];

            return $handler;
        }
    }

    /**
     * @deprecated 4.3 No longer used as we rely on ezpExtension & autoloads
     * @return array list of directories used to search cluster file handlers for
     */
    static function searchPathArray()
    {
        if ( !isset( $GLOBALS['eZClusterFileHandler_search_path_array'] ) )
        {
            $fileINI = eZINI::instance( 'file.ini' );
            $searchPathArray = array( 'kernel/classes/clusterfilehandlers',
                                      'kernel/private/classes/clusterfilehandlers' );
            if ( $fileINI->hasVariable( 'ClusteringSettings', 'ExtensionDirectories' ) )
            {
                $extensionDirectories = $fileINI->variable( 'ClusteringSettings', 'ExtensionDirectories' );
                $baseDirectory = eZExtension::baseDirectory();
                foreach ( $extensionDirectories as $extensionDirectory )
                {
                    $customSearchPath = $baseDirectory . '/' . $extensionDirectory . '/clusterfilehandlers';
                    if ( file_exists( $customSearchPath ) )
                        $searchPathArray[] = $customSearchPath;
                }
            }

            $GLOBALS['eZClusterFileHandler_search_path_array'] = $searchPathArray;
        }

        return $GLOBALS['eZClusterFileHandler_search_path_array'];
    }

    /**
     * Cluster shutdown handler. Terminates generation for unterminated files.
     * This situation doesn't happen by default, but may with custom code that doesn't follow recommendations.
     */
    static function cleanupGeneratingFiles()
    {
        if ( count( self::$generatingFiles ) === 0 )
        {
            return false;
        }
        else
        {
            eZDebug::writeWarning( "Execution was stopped while one or more files were generating. This should not happen.", __METHOD__ );
            foreach( self::$generatingFiles as $generatingFile )
            {
                $generatingFile->abortCacheGeneration();
                self::removeGeneratingFile( $generatingFile );
            }
        }

    }

    /**
     * Adds a file to the generating list
     *
     * @param eZDFSFileHandler|eZDFSFileHandler $file
     *        Cluster file handler instance
     *        Note that this method expect a version of the handler where the filePath is the REAL one, not the .generating
     */
    public static function addGeneratingFile( $file )
    {
        if ( !( $file instanceof eZDBFileHandler ) && !( $file instanceof eZDFSFileHandler ) )
            return false; // @todo Exception

        self::$generatingFiles[$file->filePath] = $file;
    }

    /**
    * Removes a file from the generating list
    * @param eZDBFileHandler|eZDFSFileHandler $file
    *        Cluster file handler instance
    *        Note that this method expect a version of the handler where the filePath is the REAL one, not the .generating

    * @todo Clustering: apply the eZClusterFileHandlerInterface to all cluster handlers
    */
    public static function removeGeneratingFile( $file )
    {
        if ( !( $file instanceof eZDBFileHandler ) && !( $file instanceof eZDFSFileHandler ) )
            return false; // @todo Exception

        if ( isset( self::$generatingFiles[$file->filePath] ) )
            unset( self::$generatingFiles[$file->filePath] );
    }
    /**
     * Global list of currently generating files. Used by handlers that support stalecache.
     * @var array(filename => eZClusterFileHandlerInterface)
     */
    private static $generatingFiles = array();

    /**
     * Shutdown registration check variable
     * @var bool
     */
    private static $isShutdownFunctionRegistered = false;
}

?>

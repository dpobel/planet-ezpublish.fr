<?php
//
// Definition of eZLog class
//
// Created on: <17-Mar-2003 11:00:54 wy>
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

/*! \defgroup eZUtils Utility classes */

/*!
  \class eZLog ezlog.php
  \ingroup eZUtils
*/


//include_once( "lib/ezutils/classes/ezsys.php" );

class eZLog
{
    const MAX_LOGROTATE_FILES = 3;
    const MAX_LOGFILE_SIZE = 204800; // 200*1024

    /*!
      Creates a new log object.
    */
    function eZLog( )
    {
    }

    /*!
     \static
     \public
     Writes a message $message to a given file name $name and directory $dir for logging
    */
    static function write( $message, $logName = 'common.log', $dir = 'var/log' )
    {
        $ini = eZINI::instance();
        $fileName = $dir . '/' . $logName;
        if ( !file_exists( $dir ) )
        {
            //include_once( 'lib/ezfile/classes/ezdir.php' );
            eZDir::mkdir( $dir, 0775, true );
        }
        $oldumask = @umask( 0 );

        $fileExisted = @file_exists( $fileName );
        if ( $fileExisted and
             filesize( $fileName ) > eZLog::maxLogSize() )
        {
            if ( eZLog::rotateLog( $fileName ) )
                $fileExisted = false;
        }

        $logFile = @fopen( $fileName, "a" );
        if ( $logFile )
        {
            $time = strftime( "%b %d %Y %H:%M:%S", strtotime( "now" ) );
            $logMessage = "[ " . $time . " ] $message\n";
            @fwrite( $logFile, $logMessage );
            @fclose( $logFile );
            if ( !$fileExisted )
                @chmod( $fileName, 0666 );
            @umask( $oldumask );
        }
    }

    /*!
     \private
     Writes file name $name and storage directory $dir to storage log
    */
    static function writeStorageLog( $name, $dir = false )
    {
        $ini = eZINI::instance();
        $varDir = $ini->variable( 'FileSettings', 'VarDir' );
        $logDir = $ini->variable( 'FileSettings', 'LogDir' );
        $logName = 'storage.log';
        $fileName = $varDir . '/' . $logDir . '/' . $logName;
        if ( !file_exists( $varDir . '/' . $logDir ) )
        {
            //include_once( 'lib/ezfile/classes/ezdir.php' );
            eZDir::mkdir( $varDir . '/' . $logDir, 0775, true );
        }
        $oldumask = @umask( 0 );

        $fileExisted = @file_exists( $fileName );
        if ( $fileExisted and
             filesize( $fileName ) > eZLog::maxLogSize() )
        {
            if ( eZLog::rotateLog( $fileName ) )
                $fileExisted = false;
        }

        if ( $dir !== false )
        {
            $dir = preg_replace( "#/$#", "", $dir );
            $dir .= "/";
        }
        else
        {
            $dir = "";
        }

        $logFile = @fopen( $fileName, "a" );
        if ( $logFile )
        {
            $time = strftime( "%b %d %Y %H:%M:%S", strtotime( "now" ) );
            $logMessage = "[ " . $time . " ] [" . $dir . $name . "]\n";
            @fwrite( $logFile, $logMessage );
            @fclose( $logFile );
            if ( !$fileExisted )
                @chmod( $fileName, 0666 );
            @umask( $oldumask );
        }
    }

    /*!
     \static
     \return the maxium size for a log file in bytes.
    */
    static function maxLogSize()
    {
        $maxLogSize =& $GLOBALS['eZMaxLogSize'];
        if ( isset( $maxLogSize ) )
            return $maxLogSize;
        return self::MAX_LOGFILE_SIZE;
    }

    /*!
     \static
     Sets the maxium size for a log file to \a $size.
    */
    static function setMaxLogSize( $size )
    {
        $GLOBALS['eZMaxLogSize'] = $size;
    }

    /*!
     \static
     \return the maxium number of logrotate files to keep.
    */
    static function maxLogrotateFiles()
    {
        $maxLogrotateFiles =& $GLOBALS['eZMaxLogrotateFiles'];
        if ( isset( $maxLogrotateFiles ) )
            return $maxLogrotateFiles;
        return self::MAX_LOGROTATE_FILES;
    }

    /*!
     \static
     Rotates logfiles so the current logfile is backed up,
     old rotate logfiles are rotated once more and those that
     exceed maxLogrotateFiles() will be removed.
     Rotated files will get the extension .1, .2 etc.
    */
    static function rotateLog( $fileName )
    {
        //include_once( 'lib/ezfile/classes/ezfile.php' );
        $maxLogrotateFiles = eZLog::maxLogrotateFiles();
        for ( $i = $maxLogrotateFiles; $i > 0; --$i )
        {
            $logRotateName = $fileName . '.' . $i;
            if ( @file_exists( $logRotateName ) )
            {
                if ( $i == $maxLogrotateFiles )
                {
                    @unlink( $logRotateName );
                }
                else
                {
                    $newLogRotateName = $fileName . '.' . ($i + 1);
                    eZFile::rename( $logRotateName, $newLogRotateName );
                }
            }
        }
        if ( @file_exists( $fileName ) )
        {
            $newLogRotateName = $fileName . '.' . 1;
            eZFile::rename( $fileName, $newLogRotateName );
            return true;
        }
        return false;
    }

    /*!
     \static
     Sets the maxium number of logrotate files to keep to \a $files.
    */
    static function setLogrotateFiles( $files )
    {
        $GLOBALS['eZMaxLogrotateFiles'] = $files;
    }

}

?>

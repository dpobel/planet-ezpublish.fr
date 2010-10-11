<?php
//
// Definition of eZDBFileHandlerMysqlBackend class
//
// Created on: <19-Apr-2006 16:15:17 vs>
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

define( 'TABLE_METADATA',     'ezdbfile' );
define( 'TABLE_DATA',         'ezdbfile_data' );

/*
CREATE TABLE ezdbfile (
  datatype      VARCHAR(60)   NOT NULL DEFAULT 'application/octet-stream',
  name          TEXT          NOT NULL,
  name_trunk    TEXT          NOT NULL,
  name_hash     VARCHAR(34)   NOT NULL DEFAULT '',
  scope         VARCHAR(20)   NOT NULL DEFAULT '',
  size          BIGINT(20)    UNSIGNED NOT NULL DEFAULT '0',
  mtime         INT(11)       NOT NULL DEFAULT '0',
  expired       BOOL          NOT NULL DEFAULT '0',
  PRIMARY KEY (name_hash),
  INDEX ezdbfile_name (name(250)),
  INDEX ezdbfile_name_trunk (name_trunk(250)),
  INDEX ezdbfile_mtime (mtime),
  INDEX ezdbfile_expired_name (expired, name(250))
) ENGINE=InnoDB;


CREATE TABLE ezdbfile_data (
  name_hash VARCHAR(34)   NOT NULL DEFAULT '',
  offset    INT(11) UNSIGNED NOT NULL,
  filedata  BLOB          NOT NULL,
  PRIMARY KEY (name_hash, offset),
  CONSTRAINT ezdbfile_fk1 FOREIGN KEY (name_hash) REFERENCES ezdbfile (name_hash) ON DELETE CASCADE
) ENGINE=InnoDB;
 */

class eZDBFileHandlerMysqlBackend
{
    function _connect( $newLink = false )
    {
        if ( !isset( $GLOBALS['eZDBFileHandlerMysqlBackend_dbparams'] ) )
        {
            $siteINI = eZINI::instance( 'site.ini' );
            $fileINI = eZINI::instance( 'file.ini' );

            $params['host']       = $fileINI->variable( 'ClusteringSettings', 'DBHost' );
            $params['port']       = $fileINI->variable( 'ClusteringSettings', 'DBPort' );
            $params['socket']     = $fileINI->variable( 'ClusteringSettings', 'DBSocket' );
            $params['dbname']     = $fileINI->variable( 'ClusteringSettings', 'DBName' );
            $params['user']       = $fileINI->variable( 'ClusteringSettings', 'DBUser' );
            $params['pass']       = $fileINI->variable( 'ClusteringSettings', 'DBPassword' );
            $params['chunk_size'] = $fileINI->variable( 'ClusteringSettings', 'DBChunkSize' );

            $params['max_connect_tries'] = $fileINI->variable( 'ClusteringSettings', 'DBConnectRetries' );
            $params['max_execute_tries'] = $fileINI->variable( 'ClusteringSettings', 'DBExecuteRetries' );

            $params['sql_output'] = $siteINI->variable( "DatabaseSettings", "SQLOutput" ) == "enabled";

            $params['cache_generation_timeout'] = $siteINI->variable( "ContentSettings", "CacheGenerationTimeout" );

            $GLOBALS['eZDBFileHandlerMysqlBackend_dbparams'] = $params;
        }
        else
            $params = $GLOBALS['eZDBFileHandlerMysqlBackend_dbparams'];
        $this->dbparams = $params;

        $serverString = $params['host'];
        if ( $params['socket'] )
            $serverString .= ':' . $params['socket'];
        elseif ( $params['port'] )
            $serverString .= ':' . $params['port'];

        $maxTries = $params['max_connect_tries'];
        $tries = 0;
        while ( $tries < $maxTries )
        {
            if ( $this->db = mysql_connect( $serverString, $params['user'], $params['pass'], $newLink ) )
                break;
            ++$tries;
        }
        if ( !$this->db )
            return $this->_die( "Unable to connect to storage server" );

        if ( !mysql_select_db( $params['dbname'], $this->db ) )
            return $this->_die( "Unable to select database {$params['dbname']}" );
    }

    function _copy( $srcFilePath, $dstFilePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_copy($srcFilePath, $dstFilePath)";
        else
            $fname = "_copy($srcFilePath, $dstFilePath)";

        // fetch source file metadata
        $metaData = $this->_fetchMetadata( $srcFilePath, $fname );
        if ( !$metaData ) // if source file does not exist then do nothing.
            return false;
        return $this->_protect( array( $this, "_copyInner" ), $fname,
                                $srcFilePath, $dstFilePath, $fname, $metaData );
    }

    function _copyInner( $srcFilePath, $dstFilePath, $fname, $metaData )
    {
        $this->_delete( $dstFilePath, true, $fname );

        $datatype        = $metaData['datatype'];
        $filePathHash    = md5( $dstFilePath );
        $scope           = $metaData['scope'];
        $contentLength   = $metaData['size'];
        $fileMTime       = $metaData['mtime'];
        $nameTrunk       = self::nameTrunk( $dstFilePath, $scope );

        // Copy file metadata.
        if ( $this->_insertUpdate( TABLE_METADATA,
                                   array( 'datatype'=> $datatype,
                                          'name' => $dstFilePath,
                                          'name_trunk' => $nameTrunk,
                                          'name_hash' => $filePathHash,
                                          'scope' => $scope,
                                          'size' => $contentLength,
                                          'mtime' => $fileMTime,
                                          'expired' => ($fileMTime < 0) ? 1 : 0 ),
                                   "datatype=VALUES(datatype), scope=VALUES(scope), size=VALUES(size), mtime=VALUES(mtime), expired=VALUES(expired)",
                                   $fname ) === false )
        {
            return $this->_fail( $srcFilePath, "Failed to insert file metadata on copying." );
        }

        // Copy file data.

        $sql = "SELECT filedata, offset FROM " . TABLE_DATA . " WHERE name_hash=" . $this->_md5( $srcFilePath ) . " ORDER BY offset";
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            eZDebug::writeError( "Failed to fetch source file '$srcFilePath' data on copying.", __METHOD__ );
            return false;
        }

        $offset = 0;
        while ( $row = mysql_fetch_row( $res ) )
        {
            // make the data mysql insert safe.
            $binarydata = $row[0];
            $expectedOffset = $row[1];
            if ( $expectedOffset != $offset )
            {
                eZDebug::writeError( "The fetched offset value '$expectedOffset' does not match the computed one for the file '$srcFilePath', aborting copy.",
                                     __METHOD__ );
                return false;
            }

            if ( $this->_insertUpdate( TABLE_DATA,
                                       array( 'name_hash' => $filePathHash,
                                              'offset' => $offset,
                                              'filedata' => $binarydata ),
                                       "filedata=VALUES(filedata)",
                                       $fname ) === false )
            {
                return $this->_fail( "Failed to insert data row while copying file." );
            }
            $offset += strlen( $binarydata );
        }
        if ( $offset != $contentLength )
        {
            eZDebug::writeError( "The size of the fetched data '$offset' does not match the expected size '$contentLength' for the file '$srcFilePath', aborting copy.",
                                 __METHOD__ );
            return false;
        }

        // Get rid of unused/old offset data.
        $result = $this->_cleanupFiledata( $dstFilePath, $contentLength, $fname );
        if ( $this->_isFailure( $result ) )
            return $result;

        return true;
    }

    /*!
     Purges meta-data and file-data for the file entry named $filePath from the database.
     */
    function _purge( $filePath, $onlyExpired = false, $expiry = false, $fname = false )
    {
        if ( $fname )
            $fname .= "::_purge($filePath)";
        else
            $fname = "_purge($filePath)";
        $sql = "DELETE FROM " . TABLE_METADATA . " WHERE name_hash=" . $this->_md5( $filePath );
        if ( $expiry !== false )
            $sql .= " AND mtime < " . (int)$expiry;
        elseif ( $onlyExpired )
            $sql .= " AND expired = 1";
        if ( !$this->_query( $sql, $fname ) )
            return $this->_fail( "Purging file metadata for $filePath failed" );
        return true;
    }

    /*!
     Purges meta-data and file-data for the matching files.
     Matching is done by passing the string $like to the LIKE statement in the SQL.
     */
    function _purgeByLike( $like, $onlyExpired = false, $limit = 50, $expiry = false, $fname = false )
    {
        if ( $fname )
            $fname .= "::_purgeByLike($like, $onlyExpired)";
        else
            $fname = "_purgeByLike($like, $onlyExpired)";
        $sql = "DELETE FROM " . TABLE_METADATA . " WHERE name LIKE " . $this->_quote( $like );
        if ( $expiry !== false )
            $sql .= " AND mtime < " . (int)$expiry;
        elseif ( $onlyExpired )
            $sql .= " AND expired = 1";
        if ( $limit )
            $sql .= " LIMIT $limit";
        if ( !$this->_query( $sql, $fname ) )
            return $this->_fail( "Purging file metadata by like statement $like failed" );
        return mysql_affected_rows( $this->db );
    }

    function _delete( $filePath, $insideOfTransaction = false, $fname = false )
    {
        if ( $fname )
            $fname .= "::_delete($filePath)";
        else
            $fname = "_delete($filePath)";
        if ( $insideOfTransaction )
        {
            $res = $this->_deleteInner( $filePath, $fname );
            if ( !$res || $res instanceof eZMySQLBackendError )
            {
                $this->_handleErrorType( $res );
            }
        }
        else
            return $this->_protect( array( $this, '_deleteInner' ), $fname,
                                    $filePath, $insideOfTransaction, $fname );
    }

    function _deleteInner( $filePath, $fname )
    {
        if ( !$this->_query( "UPDATE " . TABLE_METADATA . " SET mtime=-ABS(mtime), expired=1 WHERE name_hash=" . $this->_md5( $filePath ), $fname ) )
            return $this->_fail( "Deleting file $filePath failed" );
        return true;
    }

    function _deleteByLike( $like, $fname = false )
    {
        if ( $fname )
            $fname .= "::_deleteByLike($like)";
        else
            $fname = "_deleteByLike($like)";
        return $this->_protect( array( $this, '_deleteByLikeInner' ), $fname,
                                $like, $fname );
    }

    function _deleteByLikeInner( $like, $fname )
    {
        $sql = "UPDATE " . TABLE_METADATA . " SET mtime=-ABS(mtime), expired=1\nWHERE name like ". $this->_quote( $like );
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            return $this->_fail( "Failed to delete files by like: '$like'" );
        }
        return true;
    }

    function _deleteByRegex( $regex, $fname = false )
    {
        if ( $fname )
            $fname .= "::_deleteByRegex($regex)";
        else
            $fname = "_deleteByRegex($regex)";
        return $this->_protect( array( $this, '_deleteByRegexInner' ), $fname,
                                $regex, $fname );
    }

    function _deleteByRegexInner( $regex, $fname )
    {
        $sql = "UPDATE " . TABLE_METADATA . " SET mtime=-ABS(mtime), expired=1\nWHERE name REGEXP " . $this->_quote( $regex );
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            return $this->_fail( "Failed to delete files by regex: '$regex'" );
        }
        return true;
    }

    function _deleteByWildcard( $wildcard, $fname = false )
    {
        if ( $fname )
            $fname .= "::_deleteByWildcard($wildcard)";
        else
            $fname = "_deleteByWildcard($wildcard)";
        return $this->_protect( array( $this, '_deleteByWildcardInner' ), $fname,
                                $wildcard, $fname );
    }

    function _deleteByWildcardInner( $wildcard, $fname )
    {
        // Convert wildcard to regexp.
        $regex = '^' . mysql_real_escape_string( $wildcard ) . '$';

        $regex = str_replace( array( '.'  ),
                              array( '\.' ),
                              $regex );

        $regex = str_replace( array( '?', '*',  '{', '}', ',' ),
                              array( '.', '.*', '(', ')', '|' ),
                              $regex );

        $sql = "UPDATE " . TABLE_METADATA . " SET mtime=-ABS(mtime), expired=1\nWHERE name REGEXP '$regex'";
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            return $this->_fail( "Failed to delete files by wildcard: '$wildcard'" );
        }
        return true;
    }

    function _deleteByDirList( $dirList, $commonPath, $commonSuffix, $fname = false )
    {
        if ( $fname )
            $fname .= "::_deleteByDirList($dirList, $commonPath, $commonSuffix)";
        else
            $fname = "_deleteByDirList($dirList, $commonPath, $commonSuffix)";
        return $this->_protect( array( $this, '_deleteByDirListInner' ), $fname,
                                $dirList, $commonPath, $commonSuffix, $fname );
    }

    function _deleteByDirListInner( $dirList, $commonPath, $commonSuffix, $fname )
    {
        foreach ( $dirList as $dirItem )
        {
            if ( strstr( $commonPath, '/cache/content' ) !== false or strstr( $commonPath, '/cache/template-block' ) !== false )
            {
                $where = "WHERE name_trunk = '$commonPath/$dirItem/$commonSuffix'";
            }
            else
            {
                $where = "WHERE name LIKE '$commonPath/$dirItem/$commonSuffix%'";
            }
            $sql = "UPDATE " . TABLE_METADATA . " SET mtime=-ABS(mtime), expired=1\n$where";
            if ( !$res = $this->_query( $sql, $fname ) )
            {
                eZDebug::writeError( "Failed to delete files in dir: '$commonPath/$dirItem/$commonSuffix%'", __METHOD__ );
            }
        }
        return true;
    }


    function _exists( $filePath, $fname = false, $ignoreExpiredFiles = true )
    {
        if ( $fname )
            $fname .= "::_exists($filePath)";
        else
            $fname = "_exists($filePath)";
        $row = $this->_selectOneRow( "SELECT name, mtime FROM " . TABLE_METADATA . " WHERE name_hash=" . $this->_md5( $filePath ),
                                     $fname, "Failed to check file '$filePath' existance: ", true );
        if ( $row === false )
            return false;

        if ( $ignoreExpiredFiles )
            $rc = $row[1] >= 0;
        else
            $rc = true;

        return $rc;
    }

    function __mkdir_p( $dir )
    {
        // create parent directories
        $dirElements = explode( '/', $dir );
        if ( count( $dirElements ) == 0 )
            return true;

        $result = true;
        $currentDir = $dirElements[0];

        if ( $currentDir != '' && !file_exists( $currentDir ) && !eZDir::mkdir( $currentDir, false ))
            return false;

        for ( $i = 1; $i < count( $dirElements ); ++$i )
        {
            $dirElement = $dirElements[$i];
            if ( strlen( $dirElement ) == 0 )
                continue;

            $currentDir .= '/' . $dirElement;

            if ( !file_exists( $currentDir ) && !eZDir::mkdir( $currentDir, false ) )
                return false;

            $result = true;
        }

        return $result;
    }

    /**
    * Fetches the file $filePath from the database, saving it locally with its
    * original name, or $uniqueName if given
    *
    * @param string $filePath
    * @param string $uniqueName
    * @return the file physical path, or false if fetch failed
    **/
    function _fetch( $filePath, $uniqueName = false )
    {
        $metaData = $this->_fetchMetadata( $filePath );
        if ( !$metaData )
        {
            eZDebug::writeError( "File '$filePath' does not exist while trying to fetch.", __METHOD__ );
            return false;
        }
        $contentLength = $metaData['size'];

        $sql = "SELECT filedata, offset FROM " . TABLE_DATA . " WHERE name_hash=" . $this->_md5( $filePath ) . " ORDER BY offset";
        if ( !$res = $this->_query( $sql, "_fetch($filePath)" ) )
        {
            eZDebug::writeError( "Failed to fetch file data for file '$filePath'.", __METHOD__ );
            return false;
        }

        if( !mysql_num_rows( $res ) )
        {
            eZDebug::writeError( "No rows in file '$filePath' being fetched.", __METHOD__ );
            mysql_free_result( $res );
            return false;
        }

        // create temporary file
        if ( strrpos( $filePath, '.' ) > 0 )
            $tmpFilePath = substr_replace( $filePath, getmypid().'tmp', strrpos( $filePath, '.' ), 0  );
        else
            $tmpFilePath = $filePath . '.' . getmypid().'tmp';
        $this->__mkdir_p( dirname( $tmpFilePath ) );

        if ( !( $fp = fopen( $tmpFilePath, 'wb' ) ) )
        {
            eZDebug::writeError( "Cannot write to '$tmpFilePath' while fetching file.", __METHOD__ );
            return false;
        }

        $offset = 0;
        while ( $row = mysql_fetch_row( $res ) )
        {
            $expectedOffset = $row[1];
            if ( $expectedOffset != $offset )
            {
                eZDebug::writeError( "The fetched offset value '$expectedOffset' does not match the computed one for the file '$filePath', aborting fetch.", __METHOD__ );
                fclose( $fp );
                @unlink( $filePath );
                return false;
            }
            fwrite( $fp, $row[0] );
            $offset += strlen( $row[0] );
        }
        if ( $offset != $contentLength )
        {
            eZDebug::writeError( "The size of the fetched data '$offset' does not match the expected size '$contentLength' for the file '$filePath', aborting fetch.", __METHOD__ );
            fclose( $fp );
            @unlink( $filePath );
            return false;
        }

        fclose( $fp );

        // Make sure all data is written correctly
        clearstatcache();
        $tmpSize = filesize( $tmpFilePath );
        if ( $tmpSize != $metaData['size'] )
        {
            eZDebug::writeError( "Size ($tmpSize) of written data for file '$tmpFilePath' does not match expected size " . $metaData['size'], __METHOD__ );
            return false;
        }

        if ( ! $uniqueName === true )
        {
            eZFile::rename( $tmpFilePath, $filePath );
        }
        else
        {
            $filePath = $tmpFilePath;
        }
        mysql_free_result( $res );

        return $filePath;
    }

    function _fetchContents( $filePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_fetchContents($filePath)";
        else
            $fname = "_fetchContents($filePath)";
        $metaData = $this->_fetchMetadata( $filePath, $fname );
        if ( !$metaData )
        {
            eZDebug::writeError( "File '$filePath' does not exist while trying to fetch its contents.", __METHOD__ );
            return false;
        }
        $contentLength = $metaData['size'];

//        $fileID = $metaData['id'];
        $sql = "SELECT filedata, offset FROM " . TABLE_DATA . " WHERE name_hash=" . $this->_md5( $filePath ) . " ORDER BY offset";
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            eZDebug::writeError( "Failed to fetch file data for the file '$filePath'.", __METHOD__ );
            return false;
        }

        $contents = '';
        $offset   = 0;
        while ( $row = mysql_fetch_row( $res ) )
        {
            $expectedOffset = $row[1];
            if ( $expectedOffset != $offset )
            {
                eZDebug::writeError( "The fetched offset value '$expectedOffset' does not match the computed one for the file '$filePath', aborting.", __METHOD__ );
                return false;
            }
            $contents .= $row[0];
            $offset += strlen( $row[0] );
        }
        if ( $offset != $contentLength )
        {
            eZDebug::writeError( "The size of the fetched data '$offset' does not match the expected size '$contentLength' for the file '$filePath', aborting.", __METHOD__ );
            return false;
        }

        mysql_free_result( $res );
        return $contents;
    }

    /**
     * \return file metadata, or false if the file does not exist in database.
     */
    function _fetchMetadata( $filePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_fetchMetadata($filePath)";
        else
            $fname = "_fetchMetadata($filePath)";
        $sql = "SELECT * FROM " . TABLE_METADATA . " WHERE name_hash=" . $this->_md5( $filePath );
        return $this->_selectOneAssoc( $sql, $fname,
                                       "Failed to retrieve file metadata: $filePath",
                                       true );
    }

    function _linkCopy( $srcPath, $dstPath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_linkCopy($srcPath,$dstPath)";
        else
            $fname = "_linkCopy($srcPath,$dstPath)";
        return $this->_copy( $srcPath, $dstPath, $fname );
    }

    /**
     * \deprecated This function should not be used since it cannot handle reading errors.
     *             For the PHP 5 port this should be removed.
     */
    function _passThrough( $filePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_passThrough($filePath)";
        else
            $fname = "_passThrough($filePath)";

        $metaData = $this->_fetchMetadata( $filePath, $fname );
        if ( !$metaData )
            return false;

        $sql = "SELECT filedata FROM " . TABLE_DATA . " WHERE name_hash=" . $this->md5( $filePath ) . " ORDER BY offset";
        if ( !$res = $this->_query( $sql, $fname ) )
        {
            eZDebug::writeError( "Failed to fetch file data for file '$filePath'.", __METHOD__ );
            return false;
        }

        while ( $row = mysql_fetch_row( $res ) )
            echo $row[0];

        return true;
    }

    function _rename( $srcFilePath, $dstFilePath )
    {
        if ( strcmp( $srcFilePath, $dstFilePath ) == 0 )
            return;

        // fetch source file metadata
        $metaData = $this->_fetchMetadata( $srcFilePath );
        if ( !$metaData ) // if source file does not exist then do nothing.
            return false;

        $this->_begin( __METHOD__ );

        $srcFilePathStr  = mysql_real_escape_string( $srcFilePath );
        $dstFilePathStr  = mysql_real_escape_string( $dstFilePath );
        $dstNameTrunkStr = mysql_real_escape_string( self::nameTrunk( $dstFilePath, $metaData['scope'] ) );

//        $srcFilePathHash = mysql_real_escape_string( $metaData['name_hash'] );
//        $dstFilePathHash = mysql_real_escape_string( md5( $dstFilePath ) );

        // Mark entry for update to lock it
        $sql = "SELECT * FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$srcFilePathStr') FOR UPDATE";
        if ( !$this->_query( $sql, "_rename($srcFilePath, $dstFilePath)" ) )
        {
            eZDebug::writeError( "Failed locking file '$srcFilePath'", __METHOD__ );
            $this->_rollback( __METHOD__ );
            return false;
        }

        if ( $this->_exists( $dstFilePath, false, false ) )
            $this->_purge( $dstFilePath, false );

        // Create a new meta-data entry for the new file to make foreign keys happy.
        $sql = "INSERT INTO " . TABLE_METADATA . " (name, name_trunk, name_hash, datatype, scope, size, mtime, expired) SELECT '$dstFilePathStr' AS name, '$dstNameTrunkStr' as name_trunk, MD5('$dstFilePathStr') AS name_hash, datatype, scope, size, mtime, expired FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$srcFilePathStr')";
        if ( !$this->_query( $sql, "_rename($srcFilePath, $dstFilePath)" ) )
        {
            eZDebug::writeError( "Failed making new file entry '$dstFilePath'", __METHOD__ );
            $this->_rollback( __METHOD__ );
            return false;
        }

        // Update data chunks to refer to the new file entry.
        $sql = "UPDATE " . TABLE_DATA . " SET name_hash=MD5('$dstFilePathStr') WHERE name_hash=MD5('$srcFilePathStr')";
        if ( !$this->_query( $sql, "_rename($srcFilePath, $dstFilePath)" ) )
        {
            eZDebug::writeError( "Failed renaming file '$srcFilePath' to '$dstFilePath'", __METHOD__ );
            $this->_rollback( __METHOD__ );
            return false;
        }

        // Remove old entry
        $sql = "DELETE FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$srcFilePathStr')";
        if ( !$this->_query( $sql, "_rename($srcFilePath, $dstFilePath)" ) )
        {
            eZDebug::writeError( "Failed removing old file '$srcFilePath'", __METHOD__ );
            $this->_rollback( __METHOD__ );
            return false;
        }

        $this->_commit( __METHOD__ );

        return true;
    }

    function _store( $filePath, $datatype, $scope, $fname = false )
    {
        if ( !is_readable( $filePath ) )
        {
            eZDebug::writeError( "Unable to store file '$filePath' since it is not readable.", __METHOD__ );
            return;
        }
        if ( $fname )
            $fname .= "::_store($filePath, $datatype, $scope)";
        else
            $fname = "_store($filePath, $datatype, $scope)";

        $this->_protect( array( $this, '_storeInner' ), $fname,
                         $filePath, $datatype, $scope, $fname );
    }

    function _storeInner( $filePath, $datatype, $scope, $fname )
    {
        // Insert file metadata.
        clearstatcache();
        $fileMTime = filemtime( $filePath );
        $contentLength = filesize( $filePath );
        $filePathHash = md5( $filePath );
        $nameTrunk = self::nameTrunk( $filePath, $scope );

        if ( $this->_insertUpdate( TABLE_METADATA,
                                   array( 'datatype' => $datatype,
                                          'name' => $filePath,
                                          'name_trunk' => $nameTrunk,
                                          'name_hash' => $filePathHash,
                                          'scope' => $scope,
                                          'size' => $contentLength,
                                          'mtime' => $fileMTime,
                                          'expired' => ($fileMTime < 0) ? 1 : 0 ),
                                   "datatype=VALUES(datatype), scope=VALUES(scope), size=VALUES(size), mtime=VALUES(mtime), expired=VALUES(expired)",
                                   $fname ) === false )
        {
            return $this->_fail( "Failed to insert file metadata while storing. Possible race condition" );
        }

        // Insert file contents.
        if ( !$fp = @fopen( $filePath, 'rb' ) )
        {
            return $this->_fail( "Cannot read '$filePath'.", __METHOD__ );
        }

        $chunkSize = $this->dbparams['chunk_size'];
        $offset = 0;
        while ( !feof( $fp ) )
        {
            // make the data mysql insert safe.
            $binarydata = fread( $fp, $chunkSize );

            if ( $this->_insertUpdate( TABLE_DATA,
                                       array( 'name_hash' => $filePathHash,
                                              'offset' => $offset,
                                              'filedata' => $binarydata ),
                                       "filedata=VALUES(filedata)",
                                       $fname ) === false )
            {
                return $this->_fail( "Failed to insert file data row while storing. Possible race condition", __METHOD__ );
            }
            $offset += strlen( $binarydata );
        }
        fclose( $fp );

        // Get rid of unused/old offset data.
        $result = $this->_cleanupFiledata( $filePath, $contentLength, $fname );
        if ( $this->_isFailure( $result ) )
            return $result;

        return true;
    }

    function _storeContents( $filePath, $contents, $scope, $datatype, $mtime = false, $fname = false )
    {
        if ( $fname )
            $fname .= "::_storeContents($filePath, ..., $scope, $datatype)";
        else
            $fname = "_storeContents($filePath, ..., $scope, $datatype)";

        $this->_protect( array( $this, '_storeContentsInner' ), $fname,
                         $filePath, $contents, $scope, $datatype, $mtime, $fname );
    }

    function _storeContentsInner( $filePath, $contents, $scope, $datatype, $curTime, $fname )
    {
        // Insert file metadata.
        $contentLength = strlen( $contents );
        $filePathHash = md5( $filePath );
        $nameTrunk = self::nameTrunk( $filePath, $scope );
        if ( $curTime === false )
            $curTime = time();

        if ( $this->_insertUpdate( TABLE_METADATA,
                                    array( 'datatype' => $datatype,
                                           'name' => $filePath,
                                           'name_trunk' => $nameTrunk,
                                           'name_hash' => $filePathHash,
                                           'scope' => $scope,
                                           'size' => $contentLength,
                                           'mtime' => $curTime,
                                           'expired' => ($curTime < 0) ? 1 : 0 ),
                                    "datatype=VALUES(datatype), name_trunk='$nameTrunk', scope=VALUES(scope), size=VALUES(size), mtime=VALUES(mtime), expired=VALUES(expired)",
                                   $fname ) === false )
        {
            return $this->_fail( "Failed to insert file metadata while storing contents. Possible race condition" );
        }

        // Insert file contents.
        $chunkSize = $this->dbparams['chunk_size'];
        for ( $pos = 0; $pos < $contentLength; $pos += $chunkSize )
        {
            $chunk = substr( $contents, $pos, $chunkSize );

            if ( $this->_insertUpdate( TABLE_DATA,
                                       array( 'name_hash' => $filePathHash,
                                              'offset'   => $pos,
                                              'filedata' => $chunk ),
                                       "filedata=VALUES(filedata)",
                                       $fname ) === false )
            {
                return $this->_fail( "Failed to insert file data row while storing contents. Possible race condition" );
            }
        }

        // Get rid of unused/old offset data.
        $result = $this->_cleanupFiledata( $filePath, $contentLength, $fname );
        if ( $this->_isFailure( $result ) )
            return $result;

        return true;
    }

    function _getFileList( $scopes = false, $excludeScopes = false )
    {
        $query = 'SELECT name FROM ' . TABLE_METADATA;

        if ( is_array( $scopes ) && count( $scopes ) > 0 )
        {
            $query .= ' WHERE scope ';
            if ( $excludeScopes )
                $query .= 'NOT ';
            $query .= "IN ('" . implode( "', '", $scopes ) . "')";
        }

        $rslt = $this->_query( $query, "_getFileList( array( " . implode( ', ', $scopes ) . " ), $excludeScopes )" );
        if ( !$rslt )
        {
            eZDebug::writeDebug( 'Unable to get file list', __METHOD__ );
            return false;
        }

        $filePathList = array();
        while ( $row = mysql_fetch_row( $rslt ) )
            $filePathList[] = $row[0];

        return $filePathList;
    }

//////////////////////////////////////
//         Helper methods
//////////////////////////////////////

    function _die( $msg, $sql = null )
    {
        if ( $this->db )
        {
            eZDebug::writeError( $sql, "$msg" . mysql_error( $this->db ) );
        }
        else
        {
            eZDebug::writeError( $sql, "$msg: " . mysql_error() );
        }
    }

    /*!
    Performs an insert of the given items in $array.

    \param $table Name of table to execute insert on.
    \param $array Associative array with data to insert, the keys are the field names and the values will be quoted according to type.
    \param $fname Name of caller.
     */
    function _insert( $table, $array, $fname )
    {
        $keys = array_keys( $array );
        $query = "INSERT INTO $table (" . join( ", ", $keys ) . ") VALUES (" . $this->_sqlList( $array ) . ")";
        $res = $this->_query( $query, $fname );
        if ( !$res )
        {
            return false;
        }
        return mysql_insert_id( $this->db );
    }

    /*!
    Performs an insert of the given items in $array, if entry specified already exists the $update SQL is executed
    to update the entry.

    \param $table Name of table to execute insert on.
    \param $array Associative array with data to insert, the keys are the field names and the values will be quoted according to type.
    \param $update Partial update SQL which is executed when entry exists.
    \param $fname Name of caller.
     */
    function _insertUpdate( $table, $array, $update, $fname, $reportError = true )
    {
        $keys = array_keys( $array );
        $query = "INSERT INTO $table (" . join( ", ", $keys ) . ") VALUES (" . $this->_sqlList( $array ) . ")\nON DUPLICATE KEY UPDATE $update";
        $res = $this->_query( $query, $fname, $reportError );
        if ( !$res )
        {
            return false;
        }
        return mysql_insert_id( $this->db );
    }

    /*!
     Formats a list of entries as an SQL list which is separated by commas.
     Each entry in the list is quoted using _quote().
     */
    function _sqlList( $array )
    {
        $text = "";
        $sep = "";
        foreach ( $array as $e )
        {
            $text .= $sep;
            $text .= $this->_quote( $e );
            $sep = ", ";
        }
        return $text;
    }

    /*!
     Common select method for doing a SELECT query which is passed in $query and
     fetching one row from the result.
     If there are more than one row it will fail and exit, if 0 it returns false.
     The returned row is a numerical array.

     \param $fname The function name that started the query, should contain relevant arguments in the text.
     \param $error Sent to _error() in case of errors
     \param $debug If true it will display the fetched row in addition to the SQL.
     */
    function _selectOneRow( $query, $fname, $error = false, $debug = false )
    {
        return $this->_selectOne( $query, $fname, $error, $debug, "mysql_fetch_row" );
    }

    /*!
     Common select method for doing a SELECT query which is passed in $query and
     fetching one row from the result.
     If there are more than one row it will fail and exit, if 0 it returns false.
     The returned row is an associative array.

     \param $fname The function name that started the query, should contain relevant arguments in the text.
     \param $error Sent to _error() in case of errors
     \param $debug If true it will display the fetched row in addition to the SQL.
     */
    function _selectOneAssoc( $query, $fname, $error = false, $debug = false )
    {
        return $this->_selectOne( $query, $fname, $error, $debug, "mysql_fetch_assoc" );
    }

    /*!
     Common select method for doing a SELECT query which is passed in $query and
     fetching one row from the result.
     If there are more than one row it will fail and exit, if 0 it returns false.

     \param $fname The function name that started the query, should contain relevant arguments in the text.
     \param $error Sent to _error() in case of errors
     \param $debug If true it will display the fetched row in addition to the SQL.
     \param $fetchCall The callback to fetch the row.
     */
    function _selectOne( $query, $fname, $error = false, $debug = false, $fetchCall )
    {
        eZDebug::accumulatorStart( 'mysql_cluster_query', 'mysql_cluster_total', 'Mysql_cluster_queries' );
        $time = microtime( true );

        $res = mysql_query( $query, $this->db );
        if ( !$res )
        {
            $this->_error( $query, $fname, $error );
            eZDebug::accumulatorStop( 'mysql_cluster_query' );
            return false;
        }

        $nRows = mysql_num_rows( $res );
        if ( $nRows > 1 )
        {
            eZDebug::writeError( 'Duplicate entries found', $fname );
            eZDebug::accumulatorStop( 'mysql_cluster_query' );
            // For PHP 5 throw an exception.
        }

        $row = $fetchCall( $res );
        mysql_free_result( $res );
        if ( $debug )
            $query = "SQL for _selectOneAssoc:\n" . $query . "\n\nRESULT:\n" . var_export( $row, true );

        $time = microtime( true ) - $time;
        eZDebug::accumulatorStop( 'mysql_cluster_query' );

        $this->_report( $query, $fname, $time );
        return $row;
    }

    /*!
      Starts a new transaction by executing a BEGIN call.
      If a transaction is already started nothing is executed.
     */
    function _begin( $fname = false )
    {
        if ( $fname )
            $fname .= "::_begin";
        else
            $fname = "_begin";
        $this->transactionCount++;
        if ( $this->transactionCount == 1 )
            $this->_query( "BEGIN", $fname );
    }

    /*!
      Stops a current transaction and commits the changes by executing a COMMIT call.
      If the current transaction is a sub-transaction nothing is executed.
     */
    function _commit( $fname = false )
    {
        if ( $fname )
            $fname .= "::_commit";
        else
            $fname = "_commit";
        $this->transactionCount--;
        if ( $this->transactionCount == 0 )
            $this->_query( "COMMIT", $fname );
    }

    /*!
      Stops a current transaction and discards all changes by executing a ROLLBACK call.
      If the current transaction is a sub-transaction nothing is executed.
     */
    function _rollback( $fname = false )
    {
        if ( $fname )
            $fname .= "::_rollback";
        else
            $fname = "_rollback";
        $this->transactionCount--;
        if ( $this->transactionCount == 0 )
            $this->_query( "ROLLBACK", $fname );
    }

    /*!
     Frees a previously open shared-lock by performing a rollback on the current transaction.

     Note: There is not checking to see if a lock is started, and if
           locking was done in an existing transaction nothing will happen.
     */
    function _freeSharedLock( $fname = false )
    {
        if ( $fname )
            $fname .= "::_freeSharedLock";
        else
            $fname = "_freeSharedLock";
        $this->_rollback( $fname );
    }

    /*!
     Frees a previously open exclusive-lock by commiting the current transaction.

     Note: There is not checking to see if a lock is started, and if
           locking was done in an existing transaction nothing will happen.
     */
    function _freeExclusiveLock( $fname = false )
    {
        if ( $fname )
            $fname .= "::_freeExclusiveLock";
        else
            $fname = "_freeExclusiveLock";
        $this->_commit( $fname );
    }

    /*!
     Locks the file entry for exclusive write access.

     The locking is performed by trying to insert the entry with mtime
     set to -1, which means that file is not to be used. If it exists
     the mtime will be negated to mark it as deleted. This insert/update
     procedure will perform an exclusive lock of the row (InnoDB feature).

     Note: All reads of the row must be done with LOCK IN SHARE MODE.
     */
    function _exclusiveLock( $filePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_exclusiveLock($filePath)";
        else
            $fname = "_exclusiveLock($filePath)";
        $this->_begin( $fname );
        $data = array( 'name' => $filePath,
                       'name_hash' => md5( $filePath ),
                       'expired' => 1,
                       'mtime' => -1 ); // -1 is used to reserve this entry.
        $tries = 0;
        $maxTries = $this->dbparams['max_execute_tries'];
        while ( $tries < $maxTries )
        {
            $this->_insertUpdate( TABLE_METADATA,
                                  $data,
                                  "mtime=-ABS(mtime), expired=1",
                                  $fname,
                                  false ); // turn off error reporting
            $errno = mysql_errno( $this->db );
            if ( $errno == 1205 || // Error: 1205 SQLSTATE: HY000 (ER_LOCK_WAIT_TIMEOUT)
                 $errno == 1213 )  // Error: 1213 SQLSTATE: 40001 (ER_LOCK_DEADLOCK)
            {
                $tries++;
                continue;
            }
            else if ( $errno == 0 )
            {
                return true;
            }
            break;
        }
        return $this->_fail( "Failed to perform exclusive lock on file $filePath" );
    }

    /**
    * Uses a secondary database connection to check outside the transaction scope
    * if a file has been generated during the current process execution
    * @param string $filePath
    * @param int $expiry
    * @param int $curtime
    * @param int $ttl
    * @param string $fname
    * @return bool false if the file exists and is not expired, true otherwise
    **/
    function _verifyExclusiveLock( $filePath, $expiry, $curtime, $ttl, $fname = false )
    {
        // we need to create a new backend connection in order to be outside the
        // current transaction scope
        if ( $this->backendVerify === null )
        {
            $backendclass = get_class( $this );
            $this->backendVerify = new $backendclass( $filePath );
            $this->backendVerify->_connect( true );
        }

        // we then check the file metadata in this scope to see if it was created
        // in between
        $metaData = $this->backendVerify->_fetchMetadata( $filePath );
        if ( $metaData !== false )
        {
            if ( !eZDBFileHandler::isFileExpired( $filePath, $metaData['mtime'], max( $curtime, $expiry ), $curtime, $ttl ) )
            {
                eZDebugSetting::writeDebug( 'kernel-clustering', "DBFile '$filePath' is valid and not expired", __METHOD__ );
                return false;
            }
        }
        return true;
    }

    function _sharedLock( $filePath, $fname = false )
    {
        if ( $fname )
            $fname .= "::_sharedLock($filePath)";
        else
            $fname = "_sharedLock($filePath)";
        if ( $this->transactionCount == 0 )
            $this->_begin( $fname );
        $tries = 0;
        $maxTries = $this->dbparams['max_execute_tries'];
        while ( $tries < $maxTries )
        {
            $res = $this->_query( "SELECT * FROM " . TABLE_METADATA . " WHERE name_hash=" . $this->_md5( $filePath ) . " LOCK IN SHARE MODE", $fname, false ); // turn off error reporting
            $errno = mysql_errno( $this->db );
            if ( $errno == 1205 || // Error: 1205 SQLSTATE: HY000 (ER_LOCK_WAIT_TIMEOUT)
                 $errno == 1213 )  // Error: 1213 SQLSTATE: 40001 (ER_LOCK_DEADLOCK)
            {
                $tries++;
                continue;
            }
            break;
        }
        if ( !$res )
            return $this->_fail( "Failed to perform shared lock on file $filePath" );
        return mysql_fetch_assoc( $res );
    }

    /*!
     Protects a custom function with SQL queries in a database transaction,
     if the function reports an error the transaction is ROLLBACKed.

     The first argument to the _protect() is the callback and the second is the name of the function (for query reporting). The remainder of arguments are sent to the callback.

     A return value of false from the callback is considered a failure, any other value is returned from _protect(). For extended error handling call _fail() and return the value.
     */
    function _protect()
    {
        $args = func_get_args();
        $callback = array_shift( $args );
        $fname    = array_shift( $args );

        $maxTries = $this->dbparams['max_execute_tries'];
        $tries = 0;
        while ( $tries < $maxTries )
        {
            $this->_begin( $fname );

            $result = call_user_func_array( $callback, $args );

            $errno = mysql_errno( $this->db );
            if ( $errno == 1205 || // Error: 1205 SQLSTATE: HY000 (ER_LOCK_WAIT_TIMEOUT)
                 $errno == 1213 )  // Error: 1213 SQLSTATE: 40001 (ER_LOCK_DEADLOCK)
            {
                $tries++;
                $this->_rollback( $fname );
                continue;
            }

            if ( $result === false )
            {
                $this->_rollback( $fname );
                return false;
            }
            elseif ( $result instanceof eZMySQLBackendError )
            {
                eZDebug::writeError( $result->errorValue, $result->errorText );
                $this->_rollback( $fname );
                return false;
            }

            break; // All is good, so break out of loop
        }

        $this->_commit( $fname );
        return $result;
    }

    function _handleErrorType( $res )
    {
        if ( $res === false )
        {
            eZDebug::writeError( "SQL failed" );
        }
        elseif ( $res instanceof eZMySQLBackendError )
        {
            eZDebug::writeError( $res->errorValue, $res->errorText );
        }
    }

    /*!
     Checks if $result is a failure type and returns true if so, false otherwise.

     A failure is either the value false or an error object of type eZMySQLBackendError.
     */
    function _isFailure( $result )
    {
        if ( $result === false || ($result instanceof eZMySQLBackendError ) )
        {
            return true;
        }
        return false;
    }

    /*!
     Helper method for removing leftover file data rows for the file path $filePath.
     Note: This should be run after insert/updating filedata entries.

     Entries which are after $contentLength or which have different chunk offset than
     the defined chunk_size in $dbparams will be removed.

     \param $filePath The file path which was inserted/updated
     \param $contentLength The length of the file data
     \parma $fname Name of the function caller
     */
    function _cleanupFiledata( $filePath, $contentLength, $fname )
    {
        $chunkSize = $this->dbparams['chunk_size'];
        $sql = "DELETE FROM " . TABLE_DATA . " WHERE name_hash = " . $this->_md5( $filePath ) . " AND (offset % $chunkSize != 0 OR offset > $contentLength)";
        if ( !$this->_query( $sql, $fname ) )
            return $this->_fail( "Failed to remove old file data." );

        return true;
    }

    /*!
     Creates an error object which can be read by some backend functions.

     \param $value The value which is sent to the debug system.
     \param $text The text/header for the value.
     */
    function _fail( $value, $text = false )
    {
        $value .= "\n" . mysql_errno( $this->db ) . ": " . mysql_error( $this->db );
        return new eZMySQLBackendError( $value, $text );
    }

    /*!
     Performs mysql query and returns mysql result.
     Times the sql execution, adds accumulator timings and reports SQL to debug.

     \param $fname The function name that started the query, should contain relevant arguments in the text.
     */
    function _query( $query, $fname = false, $reportError = true )
    {
        eZDebug::accumulatorStart( 'mysql_cluster_query', 'mysql_cluster_total', 'Mysql_cluster_queries' );
        $time = microtime( true );

        $res = mysql_query( $query, $this->db );
        if ( !$res && $reportError )
        {
            $this->_error( $query, $fname );
        }

        $numRows = mysql_affected_rows( $this->db );

        $time = microtime( true ) - $time;
        eZDebug::accumulatorStop( 'mysql_cluster_query' );

        $this->_report( $query, $fname, $time, $numRows );
        return $res;
    }

    /*!
     Make sure that $value is escaped and qouted according to type and returned as a string.
     The returned value can directly be put into SQLs.
     */
    function _quote( $value )
    {
        if ( $value === null )
            return 'NULL';
        elseif ( is_integer( $value ) )
            return (string)$value;
        else
            return "'" . mysql_real_escape_string( $value ) . "'";
    }

    /*!
     Make sure that $value is escaped and qouted and turned into and MD5.
     The returned value can directly be put into SQLs.
     */
    function _md5( $value )
    {
        return "MD5('" . mysql_real_escape_string( $value ) . "')";
    }

    /*!
     Prints error message $error to debug system.

     \param $query The query that was attempted, will be printed if $error is \c false
     \param $fname The function name that started the query, should contain relevant arguments in the text.
     \param $error The error message, if this is an array the first element is the value to dump and the second the error header (for eZDebug::writeNotice). If this is \c false a generic message is shown.
     */
    function _error( $query, $fname, $error = "Failed to execute SQL for function:" )
    {
        if ( $error === false )
        {
            $error = "Failed to execute SQL for function:";
        }
        else if ( is_array( $error ) )
        {
            $fname = $error[1];
            $error = $error[0];
        }

        eZDebug::writeError( "$error\n" . mysql_errno( $this->db ) . ': ' . mysql_error( $this->db ), $fname );
    }

    /**
    * Report SQL $query to debug system.
    *
    * @param string $fname The function name that started the query, should contain relevant arguments in the text.
    * @param int    $timeTaken Number of seconds the query + related operations took (as float).
    * @param int $numRows Number of affected rows.
    **/
    function _report( $query, $fname, $timeTaken, $numRows = false )
    {
        if ( !$this->dbparams['sql_output'] )
            return;

        $rowText = '';
        if ( $numRows !== false )
            $rowText = "$numRows rows, ";
        static $numQueries = 0;
        if ( strlen( $fname ) == 0 )
            $fname = "_query";
        $backgroundClass = ($this->transactionCount > 0  ? "debugtransaction transactionlevel-$this->transactionCount" : "");
        eZDebug::writeNotice( "$query", "cluster::mysql::{$fname}[{$rowText}" . number_format( $timeTaken, 3 ) . " ms] query number per page:" . $numQueries++, $backgroundClass );
    }

    /**
    * Attempts to begin cache generation by creating a new file named as the
    * given filepath, suffixed with .generating. If the file already exists,
    * insertion is not performed and false is returned (means that the file
    * is already being generated)
    * @param string $filePath
    * @return array array with 2 indexes: 'result', containing either ok or ko,
    *         and another index that depends on the result:
    *         - if result == 'ok', the 'mtime' index contains the generating
    *           file's mtime
    *         - if result == 'ko', the 'remaining' index contains the remaining
    *           generation time (time until timeout) in seconds
    **/
    function _startCacheGeneration( $filePath, $generatingFilePath )
    {
        $fname = "_startCacheGeneration( {$filePath} )";

        $nameHash = $this->_md5( $generatingFilePath );
        $mtime = time();

        $insertData = array( 'name' => "'" . mysql_real_escape_string( $generatingFilePath ) . "'",
                             'name_trunk' => "'" . mysql_real_escape_string( $generatingFilePath ) . "'",
                             'name_hash' => $nameHash,
                             'scope' => "''",
                             'datatype' => "''",
                             'mtime' => $mtime,
                             'expired' => 0 );
        $query = 'INSERT INTO ' . TABLE_METADATA . ' ( '. implode(', ', array_keys( $insertData ) ) . ' ) ' .
                 "VALUES(" . implode( ', ', $insertData ) . ")";

        if ( !$this->_query( $query, "_startCacheGeneration( $filePath )", false ) )
        {
            $errno = mysql_errno();
            if ( $errno != 1062 )
            {
                eZDebug::writeError( "Unexpected error #$errno when trying to start cache generation on $filePath (".mysql_error().")", __METHOD__ );
                eZDebug::writeDebug( $query, '$query' );

                // @todo Make this an actual error, maybe an exception
                return array( 'res' => 'ko' );
            }
            // error 1062 is expected, since it means duplicate key (file is being generated)
            else
            {
                // generation timout check
                $query = "SELECT mtime FROM " . TABLE_METADATA . " WHERE name_hash = {$nameHash}";
                $row = $this->_selectOneRow( $query, $fname, false, false );

                // file has been renamed, i.e it is no longer a .generating file
                if( $row and !isset( $row[0] ) )
                    return array( 'result' => 'ok', 'mtime' => $mtime );

                $remainingGenerationTime = $this->remainingCacheGenerationTime( $row );
                if ( $remainingGenerationTime < 0 )
                {
                    $previousMTime = $row[0];

                    eZDebugSetting::writeDebug( 'kernel-clustering', "$filePath generation has timedout (timeout={$this->dbparams['cache_generation_timeout']}), taking over", __METHOD__ );
                    $updateQuery = "UPDATE " . TABLE_METADATA . " SET mtime = {$mtime} WHERE name_hash = {$nameHash} AND mtime = {$previousMTime}";
                    eZDebug::writeDebug( $updateQuery, '$updateQuery' );

                    // we run the query manually since the default _query won't
                    // report affected rows
                    $res = mysql_query( $updateQuery, $this->db );
                    if ( ( $res !== false ) and mysql_affected_rows( $this->db ) == 1 )
                    {
                        return array( 'result' => 'ok', 'mtime' => $mtime );
                    }
                    else
                    {
                        // @todo This would require an actual error handling
                        eZDebug::writeError( "An error occured taking over timedout generating cache file $generatingFilePath (".mysql_error().")", __METHOD__ );
                        return array( 'result' => 'error' );
                    }
                }
                else
                {
                    return array( 'result' => 'ko', 'remaining' => $remainingGenerationTime );
                }
            }
        }
        else
        {
            return array( 'result' => 'ok', 'mtime' => $mtime );
        }
    }

    /**
    * Ends the cache generation for the current file: moves the (meta)data for
    * the .generating file to the actual file, and removed the .generating
    * @param string $filePath
    * @return bool
    **/
    function _endCacheGeneration( $filePath, $generatingFilePath, $rename )
    {
        $fname = "_endCacheGeneration( $filePath )";

        eZDebugSetting::writeDebug( 'kernel-clustering', $filePath, __METHOD__ );

        // if no rename is asked, the .generating file is just removed
        if ( $rename === false )
        {
            if ( !$this->_query( "DELETE FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$generatingFilePath')" ) )
            {
                eZDebug::writeError( "Failed removing metadata entry for '$generatingFilePath'", $fname );
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            $this->_begin( $fname );

            // both files are locked for update
            if ( !$res = $this->_query( "SELECT * FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$generatingFilePath') FOR UPDATE", $fname, true ) )
            {
                $this->_rollback( $fname );
                return false;
            }
            $generatingMetaData = mysql_fetch_assoc( $res );

            $res = $this->_query( "SELECT * FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$filePath') FOR UPDATE", $fname, false );
            // the original file does not exist: we move the generating file
            if ( mysql_num_rows( $res ) == 0 )
            {
                $metaData = $generatingMetaData;
                $metaData['name'] = $filePath;
                $metaData['name_hash'] = md5( $filePath );
                $metaData['name_trunk'] = $this->nameTrunk( $filePath, $metaData['scope'] );
                $insertSQL = "INSERT INTO " . TABLE_METADATA . " ( " . implode( ', ', array_keys( $metaData ) ) . " ) " .
                             "VALUES( " . $this->_sqlList( $metaData ) . ")";
                if ( !$this->_query( $insertSQL, $fname, true ) )
                {
                    $this->_rollback( $fname );
                    return false;
                }
                if ( !$this->_query( "UPDATE " . TABLE_DATA . " SET name_hash=MD5('$filePath') WHERE name_hash=MD5('$generatingFilePath')", $fname, true ) )
                {
                    $this->_rollback( $fname );
                    return false;
                }
                $this->_query( "DELETE FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$generatingFilePath')", $fname, true );
            }
            // the original file exists: we move the generating data to this file
            // and update it
            else
            {
                $this->_query( "DELETE FROM " . TABLE_DATA . " WHERE name_hash=MD5('$filePath')", $fname, false );
                if ( !$this->_query( "UPDATE " . TABLE_DATA . " SET name_hash=MD5('$filePath') WHERE name_hash=MD5('$generatingFilePath')", $fname, true ) )
                {
                    $this->_rollback( $fname );
                    return false;
                }

                $mtime = $generatingMetaData['mtime'];
                $filesize = $generatingMetaData['size'];
                if ( !$this->_query( "UPDATE " . TABLE_METADATA . " SET mtime = '{$mtime}', expired = 0, size = '{$filesize}' WHERE name_hash=MD5('$filePath')", $fname, true ) )
                {
                    $this->_rollback( $fname );
                    return false;
                }
                $this->_query( "DELETE FROM " . TABLE_METADATA . " WHERE name_hash=MD5('$generatingFilePath')", $fname, true );
            }

            $this->_commit( $fname );
        }

        return true;
    }

    /**
    * Checks if generation has timed out by looking for the .generating file
    * and comparing its timestamp to the one assigned when the file was created
    *
    * @param string $generatingFilePath
    * @param int    $generatingFileMtime
    *
    * @return bool true if the file didn't timeout, false otherwise
    **/
    function _checkCacheGenerationTimeout( $generatingFilePath, $generatingFileMtime )
    {
        $fname = "_checkCacheGenerationTimeout( $generatingFilePath, $generatingFileMtime )";
        eZDebugSetting::writeDebug( 'kernel-clustering', "Checking for timeout of '$generatingFilePath' with mtime $generatingFileMtime", $fname );

        // reporting
        eZDebug::accumulatorStart( 'mysql_cluster_query', 'mysql_cluster_total', 'Mysql_cluster_queries' );
        $time = microtime( true );

        $nameHash = $this->_md5( $generatingFilePath );
        $newMtime = time();

        // The update query will only succeed if the mtime wasn't changed in between
        $query = "UPDATE " . TABLE_METADATA . " SET mtime = $newMtime WHERE name_hash = {$nameHash} AND mtime = $generatingFileMtime";
        $res = mysql_query( $query, $this->db );
        if ( !$res )
        {
            $this->_error( $query, $fname );
            return false;
        }
        $numRows = mysql_affected_rows( $this->db );

        // reporting. Manual here since we don't use _query
        $time = microtime( true ) - $time;
        $this->_report( $query, $fname, $time, $numRows );

        // no rows affected or row updated with the same value
        // f.e a cache-block which takes less than 1 sec to get generated
        // if a line has been updated by the same  values, mysql_affected_rows
        // returns 0, and updates nothing, we need to extra check this,
        if( $numRows == 0 )
        {
            $query = "SELECT mtime FROM " . TABLE_METADATA . " WHERE name_hash = {$nameHash}";
            $res = mysql_query( $query, $this->db );
            mysql_fetch_row( $res );
            if( $res and isset( $row[0] ) and $row[0] == $generatingFileMtime );
                return true;

            return false;
        }
        // rows affected: mtime has changed, or row has been removed
        if ( $numRows == 1 )
        {
            return true;
        }
        else
        {
            eZDebugSetting::writeDebug( 'kernel-clustering', "No rows affected by query '$query', record has been modified", __METHOD__ );
            return false;
        }
    }

    /**
    * Aborts the cache generation process by removing the .generating file
    * @param string $filePath Real cache file path
    * @param string $generatingFilePath .generating cache file path
    * @return void
    **/
    function _abortCacheGeneration( $generatingFilePath )
    {
        $sql = "DELETE FROM " . TABLE_METADATA . " WHERE name_hash = " . $this->_md5( $generatingFilePath );
        $this->_query( $sql, "_abortCacheGeneration( '$generatingFilePath' )" );
    }

    /**
    * Returns the name_trunk for a file path
    * @param string $filePath
    * @param string $scope
    * @return string
    **/
    static function nameTrunk( $filePath, $scope )
    {
        switch ( $scope )
        {
            case 'viewcache':
            {
                $nameTrunk = substr( $filePath, 0, strrpos( $filePath, '-' ) + 1 );
            } break;

            case 'template-block':
            {
                $templateBlockCacheDir = eZTemplateCacheBlock::templateBlockCacheDir();
                $templateBlockPath = str_replace( $templateBlockCacheDir, '', $filePath );
                if ( strstr( $templateBlockPath, 'subtree/' ) !== false )
                {
                    // 6 = strlen( 'cache/' );
                    $len = strlen( $templateBlockCacheDir ) + strpos( $templateBlockPath, 'cache/' ) + 6;
                    $nameTrunk = substr( $filePath, 0, $len  );
                }
                else
                {
                    $nameTrunk = $filePath;
                }
            } break;

            default:
            {
                $nameTrunk = $filePath;
            }
        }
        return $nameTrunk;
    }

    /**
    * Returns the remaining time, in seconds, before the generating file times
    * out
    *
    * @param resource $fileRow
    *
    * @return int Remaining generation seconds. A negative value indicates a timeout.
    **/
    private function remainingCacheGenerationTime( $row )
    {
        if( !isset( $row[0] ) )
            return -1;

        return ( $row[0] + $this->dbparams['cache_generation_timeout'] ) - time();
    }
    
    /**
     * Returns the list of expired binary files (images + binaries)
     * 
     * @param array $scopes Array of scopes to consider. At least one.
     * @param int $limit Max number of items. Set to false for unlimited.
     * 
     * @return array(filepath)
     * 
     * @since 4.3
     */
    public function expiredFilesList( $scopes, $limit = array( 0, 100 ) )
    {
        if ( count( $scopes ) == 0 )
            throw new ezcBaseValueException( 'scopes', $scopes, "array of scopes", "parameter" );
        
        $scopeString = $this->_sqlList( $scopes );
        $query = "SELECT name FROM " . TABLE_METADATA . " WHERE expired = 1 AND scope IN( $scopeString )";
        if ( $limit !== false )
        {
            $query .= " LIMIT {$limit[0]}, {$limit[1]}";
        }
        $res = $this->_query( $query, __METHOD__ );
        $filePathList = array();
        while ( $row = mysql_fetch_row( $res ) )
            $filePathList[] = $row[0];

        return $filePathList;
    }

    public $db   = null;
    public $numQueries = 0;
    public $transactionCount = 0;
    public $dbparams;
    private $backendVerify = null;
}

?>

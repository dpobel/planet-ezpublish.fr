<?php
//
// $Id$
//
// Definition of eZMySQLDB class
//
// Created on: <12-Feb-2002 15:54:17 bf>
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

/*!
  \class eZMySQLDB ezmysqldb.php
  \ingroup eZDB
  \brief The eZMySQLDB class provides MySQL implementation of the database interface.

  eZMySQLDB is the MySQL implementation of eZDB.
  \sa eZDB
*/
class eZMySQLDB extends eZDBInterface
{
    /*!
      Create a new eZMySQLDB object and connects to the database backend.
    */
    function eZMySQLDB( $parameters )
    {
        $this->eZDBInterface( $parameters );

        $this->CharsetMapping = array( 'iso-8859-1' => 'latin1',
                                       'iso-8859-2' => 'latin2',
                                       'iso-8859-8' => 'hebrew',
                                       'iso-8859-7' => 'greek',
                                       'iso-8859-9' => 'latin5',
                                       'iso-8859-13' => 'latin7',
                                       'windows-1250' => 'cp1250',
                                       'windows-1251' => 'cp1251',
                                       'windows-1256' => 'cp1256',
                                       'windows-1257' => 'cp1257',
                                       'utf-8' => 'utf8',
                                       'koi8-r' => 'koi8r',
                                       'koi8-u' => 'koi8u' );

        if ( !extension_loaded( 'mysql' ) )
        {
            if ( function_exists( 'eZAppendWarningItem' ) )
            {
                eZAppendWarningItem( array( 'error' => array( 'type' => 'ezdb',
                                                              'number' => eZDBInterface::ERROR_MISSING_EXTENSION ),
                                            'text' => 'MySQL extension was not found, the DB handler will not be initialized.' ) );
                $this->IsConnected = false;
            }
            eZDebug::writeWarning( 'MySQL extension was not found, the DB handler will not be initialized.', 'eZMySQLDB' );
            return;
        }

        /// Connect to master server
        if ( $this->DBWriteConnection == false )
        {
            $connection = $this->connect( $this->Server, $this->DB, $this->User, $this->Password, $this->SocketPath, $this->Charset, $this->Port );
            if ( $this->IsConnected )
            {
                $this->DBWriteConnection = $connection;
            }
        }

        // Connect to slave
        if ( $this->DBConnection == false )
        {
            if ( $this->UseSlaveServer === true )
            {
                $connection = $this->connect( $this->SlaveServer, $this->SlaveDB, $this->SlaveUser, $this->SlavePassword, $this->SocketPath, $this->Charset, $this->SlavePort );
            }
            else
            {
                $connection = $this->DBWriteConnection;
            }

            if ( $connection and $this->DBWriteConnection )
            {
                $this->DBConnection = $connection;
                $this->IsConnected = true;
            }
        }

        // Initialize TempTableList
        $this->TempTableList = array();

        eZDebug::createAccumulatorGroup( 'mysql_total', 'Mysql Total' );
    }

    /*!
     \private
     Opens a new connection to a MySQL database and returns the connection
    */
    function connect( $server, $db, $user, $password, $socketPath, $charset = null, $port = false )
    {
        // if a port is specified, we add it to $server, this is how mysql_(p)connect accepts a port number
        if ( $port )
        {
            $server .= ':' . $port;
        }

        $connection = false;

        if ( $socketPath !== false )
        {
            ini_set( "mysql.default_socket", $socketPath );
        }

        if ( $this->UsePersistentConnection == true )
        {
            $connection = mysql_pconnect( $server, $user, $password );
        }
        else
        {
            $connection = mysql_connect( $server, $user, $password, true );
        }
        $dbErrorText = mysql_error();
        $maxAttempts = $this->connectRetryCount();
        $waitTime = $this->connectRetryWaitTime();
        $numAttempts = 1;
        while ( $connection == false and $numAttempts <= $maxAttempts )
        {
            sleep( $waitTime );
            if ( $this->UsePersistentConnection == true )
            {
                $connection = mysql_pconnect( $this->Server, $this->User, $this->Password );
            }
            else
            {
                $connection = mysql_connect( $this->Server, $this->User, $this->Password );
            }
            $numAttempts++;
        }
        $this->setError();

        $this->IsConnected = true;

        if ( $connection == false )
        {
            eZDebug::writeError( "Connection error: Couldn't connect to database. Please try again later or inform the system administrator.\n$dbErrorText", "eZMySQLDB" );
            $this->IsConnected = false;
            throw new eZDBNoConnectionException( $server );
        }

        if ( $this->IsConnected && $db != null )
        {
            $ret = mysql_select_db( $db, $connection );
            $this->setError();
            if ( !$ret )
            {
                eZDebug::writeError( "Connection error: " . mysql_errno( $connection ) . ": " . mysql_error( $connection ), "eZMySQLDB" );
                $this->IsConnected = false;
            }
        }

        if ( $charset !== null )
        {
            $charset = eZCharsetInfo::realCharsetCode( $charset );
            // Convert charset names into something MySQL will understand
            if ( isset( $this->CharsetMapping[ $charset ] ) )
                $charset = $this->CharsetMapping[ $charset ];
        }

        if ( $this->IsConnected and $charset !== null and $this->isCharsetSupported( $charset ) )
        {
            $versionInfo = $this->databaseServerVersion();

            // We require MySQL 4.1.1 to use the new character set functionality,
            // MySQL 4.1.0 does not have a full implementation of this, see:
            // http://dev.mysql.com/doc/mysql/en/Charset.html
            if ( version_compare( $versionInfo['string'], '4.1.1' ) >= 0 )
            {
                $query = "SET NAMES '" . $charset . "'";
                $status = mysql_query( $query, $connection );
                $this->reportQuery( 'eZMySQLDB', $query, false, false, true );
                if ( !$status )
                {
                    $this->setError();
                    eZDebug::writeWarning( "Connection warning: " . mysql_errno( $connection ) . ": " . mysql_error( $connection ), "eZMySQLDB" );
                }
            }
        }

        return $connection;
    }

    function databaseName()
    {
        return 'mysql';
    }

    function bindingType( )
    {
        return eZDBInterface::BINDING_NO;
    }

    function bindVariable( $value, $fieldDef = false )
    {
        return $value;
    }

    /*!
      Checks if the requested character set matches the one used in the database.

      \return \c true if it matches or \c false if it differs.
      \param[out] $currentCharset The charset that the database uses.
                                  will only be set if the match fails.
                                  Note: This will be specific to the database.

      \note There will be no check for databases using MySQL 4.1.0 or lower since
            they do not have proper character set handling.
    */
    function checkCharset( $charset, &$currentCharset )
    {
        // If we don't have a database yet we shouldn't check it
        if ( !$this->DB )
            return true;

        $versionInfo = $this->databaseServerVersion();

        // We require MySQL 4.1.1 to use the new character set functionality,
        // MySQL 4.1.0 does not have a full implementation of this, see:
        // http://dev.mysql.com/doc/mysql/en/Charset.html
        // Older version should not check character sets
        if ( version_compare( $versionInfo['string'], '4.1.1' ) < 0 )
            return true;

        if ( is_array( $charset ) )
        {
            foreach ( $charset as $charsetItem )
                $realCharset[] = eZCharsetInfo::realCharsetCode( $charsetItem );
        }
        else
            $realCharset = eZCharsetInfo::realCharsetCode( $charset );

        return $this->checkCharsetPriv( $realCharset, $currentCharset );
    }

    /*!
     \private
    */
    function checkCharsetPriv( $charset, &$currentCharset )
    {
        $query = "SHOW CREATE DATABASE `{$this->DB}`";
        $status = mysql_query( $query, $this->DBConnection );
        $this->reportQuery( 'eZMySQLDB', $query, false, false );
        if ( !$status )
        {
            $this->setError();
            eZDebug::writeWarning( "Connection warning: " . mysql_errno( $this->DBConnection ) . ": " . mysql_error( $this->DBConnection ), "eZMySQLDB" );
            return false;
        }

        $numRows = mysql_num_rows( $status );
        if ( $numRows == 0 )
            return false;

        for ( $i = 0; $i < $numRows; ++$i )
        {
            $tmpRow = mysql_fetch_array( $status, MYSQL_ASSOC );
            if ( $tmpRow['Database'] == $this->DB )
            {
                $createText = $tmpRow['Create Database'];
                if ( preg_match( '#DEFAULT CHARACTER SET ([a-zA-Z0-9_-]+)#', $createText, $matches ) )
                {
                    $currentCharset = $matches[1];
                    $currentCharset = eZCharsetInfo::realCharsetCode( $currentCharset );
                    // Convert charset names into something MySQL will understand

                    $key = array_search( $currentCharset, $this->CharsetMapping );
                    $unmappedCurrentCharset = ( $key === false ) ? $currentCharset : $key;

                    if ( is_array( $charset ) )
                    {
                        if ( in_array( $unmappedCurrentCharset, $charset ) )
                        {
                            return $unmappedCurrentCharset;
                        }
                    }
                    else if ( $unmappedCurrentCharset == $charset )
                    {
                        return true;
                    }
                    return false;
                }
                break;
            }
        }
        return true;
    }

    function query( $sql, $server = false )
    {
        if ( $this->IsConnected )
        {
            eZDebug::accumulatorStart( 'mysql_query', 'mysql_total', 'Mysql_queries' );
            // The converted sql should not be output
            if ( $this->InputTextCodec )
            {
                eZDebug::accumulatorStart( 'mysql_conversion', 'mysql_total', 'String conversion in mysql' );
                $sql = $this->InputTextCodec->convertString( $sql );
                eZDebug::accumulatorStop( 'mysql_conversion' );
            }

            if ( $this->OutputSQL )
            {
                $this->startTimer();
            }

            $sql = trim( $sql );

            // Check if we need to use the master or slave server by default
            if ( $server === false )
            {
                $server = strncasecmp( $sql, 'select', 6 ) === 0 && $this->TransactionCounter == 0 ?
                    eZDBInterface::SERVER_SLAVE : eZDBInterface::SERVER_MASTER;
            }

            $connection = ( $server == eZDBInterface::SERVER_SLAVE ) ? $this->DBConnection : $this->DBWriteConnection;

            $analysisText = false;
            // If query analysis is enable we need to run the query
            // with an EXPLAIN in front of it
            // Then we build a human-readable table out of the result
            if ( $this->QueryAnalysisOutput )
            {
                $analysisResult = mysql_query( 'EXPLAIN ' . $sql, $connection );
                if ( $analysisResult )
                {
                    $numRows = mysql_num_rows( $analysisResult );
                    $rows = array();
                    if ( $numRows > 0 )
                    {
                        for ( $i = 0; $i < $numRows; ++$i )
                        {
                            if ( $this->InputTextCodec )
                            {
                                $tmpRow = mysql_fetch_array( $analysisResult, MYSQL_ASSOC );
                                $convRow = array();
                                foreach( $tmpRow as $key => $row )
                                {
                                    $convRow[$key] = $this->OutputTextCodec->convertString( $row );
                                }
                                $rows[$i] = $convRow;
                            }
                            else
                                $rows[$i] = mysql_fetch_array( $analysisResult, MYSQL_ASSOC );
                        }
                    }

                    // Figure out all columns and their maximum display size
                    $columns = array();
                    foreach ( $rows as $row )
                    {
                        foreach ( $row as $col => $data )
                        {
                            if ( !isset( $columns[$col] ) )
                                $columns[$col] = array( 'name' => $col,
                                                        'size' => strlen( $col ) );
                            $columns[$col]['size'] = max( $columns[$col]['size'], strlen( $data ) );
                        }
                    }

                    $analysisText = '';
                    $delimiterLine = array();
                    // Generate the column line and the vertical delimiter
                    // The look of the table is taken from the MySQL CLI client
                    // It looks like this:
                    // +-------+-------+
                    // | col_a | col_b |
                    // +-------+-------+
                    // | txt   |    42 |
                    // +-------+-------+
                    foreach ( $columns as $col )
                    {
                        $delimiterLine[] = str_repeat( '-', $col['size'] + 2 );
                        $colLine[] = ' ' . str_pad( $col['name'], $col['size'], ' ', STR_PAD_RIGHT ) . ' ';
                    }
                    $delimiterLine = '+' . join( '+', $delimiterLine ) . "+\n";
                    $analysisText = $delimiterLine;
                    $analysisText .= '|' . join( '|', $colLine ) . "|\n";
                    $analysisText .= $delimiterLine;

                    // Go trough all data and pad them to create the table correctly
                    foreach ( $rows as $row )
                    {
                        $rowLine = array();
                        foreach ( $columns as $col )
                        {
                            $name = $col['name'];
                            $size = $col['size'];
                            $data = isset( $row[$name] ) ? $row[$name] : '';
                            // Align numerical values to the right (ie. pad left)
                            $rowLine[] = ' ' . str_pad( $row[$name], $size, ' ',
                                                        is_numeric( $row[$name] ) ? STR_PAD_LEFT : STR_PAD_RIGHT ) . ' ';
                        }
                        $analysisText .= '|' . join( '|', $rowLine ) . "|\n";
                        $analysisText .= $delimiterLine;
                    }

                    // Reduce memory usage
                    unset( $rows, $delimiterLine, $colLine, $columns );
                }
            }

            $result = mysql_query( $sql, $connection );

            if ( $this->RecordError and !$result )
                $this->setError();

            if ( $this->OutputSQL )
            {
                $this->endTimer();

                if ($this->timeTaken() > $this->SlowSQLTimeout)
                {
                    $num_rows = mysql_affected_rows( $connection );
                    $text = $sql;

                    // If we have some analysis text we append this to the SQL output
                    if ( $analysisText !== false )
                        $text = "EXPLAIN\n" . $text . "\n\nANALYSIS:\n" . $analysisText;

                    $this->reportQuery( ( $server == eZDBInterface::SERVER_MASTER ? 'on master : ' : '' ) . 'eZMySQLDB', $text, $num_rows, $this->timeTaken() );
                }
            }
            eZDebug::accumulatorStop( 'mysql_query' );
            if ( $result )
            {
                return $result;
            }
            else
            {
                $errorMessage = "Query error: " . mysql_error( $connection ) . ". Query: ". $sql;
                eZDebug::writeError( $errorMessage, "eZMySQLDB"  );
                $oldRecordError = $this->RecordError;
                // Turn off error handling while we unlock
                $this->RecordError = false;
                mysql_query( 'UNLOCK TABLES', $connection );
                $this->RecordError = $oldRecordError;

                $this->reportError();

                // This is to behave the same way as other RDBMS PHP API as PostgreSQL
                // functions which throws an error with a failing request.
                trigger_error( "mysql_query(): $errorMessage", E_USER_ERROR );

                return false;
            }
        }
        else
        {
            eZDebug::writeError( "Trying to do a query without being connected to a database!", "eZMySQLDB"  );
        }


    }

    function arrayQuery( $sql, $params = array(), $server = false )
    {
        $retArray = array();
        if ( $this->IsConnected )
        {
            $limit = false;
            $offset = 0;
            $column = false;
            // check for array parameters
            if ( is_array( $params ) )
            {
                if ( isset( $params["limit"] ) and is_numeric( $params["limit"] ) )
                    $limit = $params["limit"];

                if ( isset( $params["offset"] ) and is_numeric( $params["offset"] ) )
                    $offset = $params["offset"];

                if ( isset( $params["column"] ) and ( is_numeric( $params["column"] ) or is_string( $params["column"] ) ) )
                    $column = $params["column"];
            }

            if ( $limit !== false and is_numeric( $limit ) )
            {
                $sql .= "\nLIMIT $offset, $limit ";
            }
            else if ( $offset !== false and is_numeric( $offset ) and $offset > 0 )
            {
                $sql .= "\nLIMIT $offset, 18446744073709551615"; // 2^64-1
            }
            $result = $this->query( $sql, $server );

            if ( $result == false )
            {
                $this->reportQuery( 'eZMySQLDB', $sql, false, false );
                return false;
            }

            $numRows = mysql_num_rows( $result );
            if ( $numRows > 0 )
            {
                if ( !is_string( $column ) )
                {
                    eZDebug::accumulatorStart( 'mysql_loop', 'mysql_total', 'Looping result' );
                    for ( $i=0; $i < $numRows; $i++ )
                    {
                        if ( $this->InputTextCodec )
                        {
                            $tmpRow = mysql_fetch_array( $result, MYSQL_ASSOC );
                            $convRow = array();
                            foreach( $tmpRow as $key => $row )
                            {
                                eZDebug::accumulatorStart( 'mysql_conversion', 'mysql_total', 'String conversion in mysql' );
                                $convRow[$key] = $this->OutputTextCodec->convertString( $row );
                                eZDebug::accumulatorStop( 'mysql_conversion' );
                            }
                            $retArray[$i + $offset] = $convRow;
                        }
                        else
                            $retArray[$i + $offset] = mysql_fetch_array( $result, MYSQL_ASSOC );
                    }
                    eZDebug::accumulatorStop( 'mysql_loop' );

                }
                else
                {
                    eZDebug::accumulatorStart( 'mysql_loop', 'mysql_total', 'Looping result' );
                    for ( $i=0; $i < $numRows; $i++ )
                    {
                        $tmp_row = mysql_fetch_array( $result, MYSQL_ASSOC );
                        if ( $this->InputTextCodec )
                        {
                            eZDebug::accumulatorStart( 'mysql_conversion', 'mysql_total', 'String conversion in mysql' );
                            $retArray[$i + $offset] = $this->OutputTextCodec->convertString( $tmp_row[$column] );
                            eZDebug::accumulatorStop( 'mysql_conversion' );
                        }
                        else
                            $retArray[$i + $offset] =& $tmp_row[$column];
                    }
                    eZDebug::accumulatorStop( 'mysql_loop' );
                }
            }
        }
        return $retArray;
    }

    function subString( $string, $from, $len = null )
    {
        if ( $len == null )
        {
            return " substring( $string from $from ) ";
        }else
        {
            return " substring( $string from $from for $len ) ";
        }
    }

    function concatString( $strings = array() )
    {
        $str = implode( "," , $strings );
        return " concat( $str  ) ";
    }

    function md5( $str )
    {
        return " MD5( $str ) ";
    }

    function bitAnd( $arg1, $arg2 )
    {
        return 'cast(' . $arg1 . ' & ' . $arg2 . ' AS SIGNED ) ';
    }

    function bitOr( $arg1, $arg2 )
    {
        return 'cast( ' . $arg1 . ' | ' . $arg2 . ' AS SIGNED ) ';
    }

    function supportedRelationTypeMask()
    {
        return eZDBInterface::RELATION_TABLE_BIT;
    }

    function supportedRelationTypes()
    {
        return array( eZDBInterface::RELATION_TABLE );
    }

    function relationCounts( $relationMask )
    {
        if ( $relationMask & eZDBInterface::RELATION_TABLE_BIT )
            return $this->relationCount();
        else
            return 0;
    }

    function relationCount( $relationType = eZDBInterface::RELATION_TABLE )
    {
        if ( $relationType != eZDBInterface::RELATION_TABLE )
        {
            eZDebug::writeError( "Unsupported relation type '$relationType'", 'eZMySQLDB::relationCount' );
            return false;
        }
        $count = false;
        if ( $this->IsConnected )
        {
            $query = "SHOW TABLES FROM `" . $this->DB . "`";
            $result = @mysql_query( $query, $this->DBConnection );
            $this->reportQuery( 'eZMySQLDB', $query, false, false );
            $count = mysql_num_rows( $result );
            mysql_free_result( $result );
        }
        return $count;
    }

    function relationList( $relationType = eZDBInterface::RELATION_TABLE )
    {
        if ( $relationType != eZDBInterface::RELATION_TABLE )
        {
            eZDebug::writeError( "Unsupported relation type '$relationType'", 'eZMySQLDB::relationList' );
            return false;
        }
        $tables = array();
        if ( $this->IsConnected )
        {
            $query = "SHOW TABLES FROM `" . $this->DB . "`";
            $result = @mysql_query( $query, $this->DBConnection );
            $this->reportQuery( 'eZMySQLDB', $query, false, false );
            $count = mysql_num_rows( $result );
            for ( $i = 0; $i < $count; ++ $i )
            {
                $table = mysql_fetch_array( $result );
                $tables[] = $table[0];
            }
            mysql_free_result( $result );
        }
        return $tables;
    }

    function eZTableList( $server = eZDBInterface::SERVER_MASTER )
    {
        $tables = array();
        if ( $this->IsConnected )
        {
            if ( $this->UseSlaveServer && $server == eZDBInterface::SERVER_SLAVE )
            {
                $connection = $this->DBConnection;
                $db = $this->SlaveDB;
            }
            else
            {
                $connection = $this->DBWriteConnection;
                $db = $this->DB;
            }

            $query = "SHOW TABLES FROM `" . $db . "`";
            $result = @mysql_query( $query, $connection );
            $this->reportQuery( 'eZMySQLDB', $query, false, false );
            $count = mysql_num_rows( $result );
            for ( $i = 0; $i < $count; ++ $i )
            {
                $table = mysql_fetch_array( $result );
                $tableName = $table[0];
                if ( substr( $tableName, 0, 2 ) == 'ez' )
                {
                    $tables[$tableName] = eZDBInterface::RELATION_TABLE;
                }
            }
            mysql_free_result( $result );
        }
        return $tables;
    }

    function relationMatchRegexp( $relationType )
    {
        return "#^ez#";
    }

    function removeRelation( $relationName, $relationType )
    {
        $relationTypeName = $this->relationName( $relationType );
        if ( !$relationTypeName )
        {
            eZDebug::writeError( "Unknown relation type '$relationType'", 'eZMySQLDB::removeRelation' );
            return false;
        }

        if ( $this->IsConnected )
        {
            $sql = "DROP $relationTypeName $relationName";
            return $this->query( $sql );
        }
        return false;
    }

    function lock( $table )
    {
        if ( $this->IsConnected )
        {
            if ( is_array( $table ) )
            {
                $lockQuery = "LOCK TABLES";
                $first = true;
                foreach( array_keys( $table ) as $tableKey )
                {
                    if ( $first == true )
                        $first = false;
                    else
                        $lockQuery .= ",";
                    $lockQuery .= " " . $table[$tableKey]['table'] . " WRITE";
                }
                $this->query( $lockQuery );
            }
            else
            {
                $this->query( "LOCK TABLES $table WRITE" );
            }
        }
    }

    function unlock()
    {
        if ( $this->IsConnected )
        {
            $this->query( "UNLOCK TABLES" );
        }
    }

    /*!
     The query to start the transaction.
    */
    function beginQuery()
    {
        return $this->query("BEGIN WORK");
    }

    /*!
     The query to commit the transaction.
    */
    function commitQuery()
    {
        return $this->query( "COMMIT" );
    }

    /*!
     The query to cancel the transaction.
    */
    function rollbackQuery()
    {
        return $this->query( "ROLLBACK" );
    }

    function lastSerialID( $table = false, $column = false )
    {
        if ( $this->IsConnected )
        {
            $id = mysql_insert_id( $this->DBWriteConnection );
            return $id;
        }
        else
            return false;
    }

    function escapeString( $str )
    {
        if ( $this->IsConnected )
        {
            return mysql_real_escape_string( $str, $this->DBConnection );
        }
        else
        {
            return mysql_escape_string( $str );
        }
    }

    function close()
    {
        if ( $this->IsConnected )
        {
            if ( $this->UseSlaveServer === true )
                mysql_close( $this->DBConnection );
            mysql_close( $this->DBWriteConnection );
        }
    }

    function createDatabase( $dbName )
    {
        if ( $this->DBConnection != false )
        {
            $this->query( "CREATE DATABASE $dbName" );
            $this->setError();
        }
    }

    function removeDatabase( $dbName )
    {
        if ( $this->DBConnection != false )
        {
            $this->query( "DROP DATABASE $dbName" );
            $this->setError();
        }
    }

    function setError()
    {
        if ( $this->DBConnection )
        {
            $this->ErrorMessage = mysql_error( $this->DBConnection );
            $this->ErrorNumber = mysql_errno( $this->DBConnection );
        }
        else
        {
            $this->ErrorMessage = mysql_error();
            $this->ErrorNumber = mysql_errno();
        }
    }

    function availableDatabases()
    {
        $databaseArray = mysql_list_dbs( $this->DBConnection );

        if ( $this->errorNumber() != 0 )
        {
            return null;
        }

        $databases = array();
        $i = 0;
        $numRows = mysql_num_rows( $databaseArray );
        if ( count( $numRows ) == 0 )
        {
            return false;
        }

        $dbServerVersion = $this->databaseServerVersion();
        $dbServerMainVersion = $dbServerVersion['values'][0];

        while ( $i < $numRows )
        {
            // we don't allow "mysql" or "information_schema" database to be shown anywhere
            $curDB = mysql_db_name( $databaseArray, $i );
            if ( strcasecmp( $curDB, 'mysql' ) != 0 && strcasecmp( $curDB, 'information_schema' ) != 0 )
            {
                $databases[] = $curDB;
            }
            ++$i;
        }
        return $databases;
    }

    function databaseServerVersion()
    {
        $versionInfo = mysql_get_server_info();

        $versionArray = explode( '.', $versionInfo );

        return array( 'string' => $versionInfo,
                      'values' => $versionArray );
    }

    function databaseClientVersion()
    {
        $versionInfo = mysql_get_client_info();

        $versionArray = explode( '.', $versionInfo );

        return array( 'string' => $versionInfo,
                      'values' => $versionArray );
    }

    function isCharsetSupported( $charset )
    {
        if ( $charset == 'utf-8' )
        {
            $versionInfo = $this->databaseServerVersion();

            // We require MySQL 4.1.1 to use the new character set functionality,
            // MySQL 4.1.0 does not have a full implementation of this, see:
            // http://dev.mysql.com/doc/mysql/en/Charset.html
            return ( version_compare( $versionInfo['string'], '4.1.1' ) >= 0 );
        }
        else
        {
            return true;
        }
    }

    function supportsDefaultValuesInsertion()
    {
        return false;
    }

    function dropTempTable( $dropTableQuery = '', $server = self::SERVER_SLAVE )
    {
        $dropTableQuery = str_ireplace( 'DROP TABLE', 'DROP TEMPORARY TABLE', $dropTableQuery );
        parent::dropTempTable( $dropTableQuery, $server );
    }

    public $CharsetMapping;
    public $TempTableList;

    /// \privatesection
}

?>

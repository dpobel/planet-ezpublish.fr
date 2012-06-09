<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/**
 * DB/MySQL cluster gateway
 * @deprecated Deprecated as of eZ Publish Etna (4.7)
 */
class ezpDbMySQLClusterGateway extends ezpClusterGateway
{
    protected $port = 3306;

    public function connect()
    {
        if ( !$this->db = mysql_connect( "$this->host:$this->port", $this->user, $this->password, true ) )
            throw new RuntimeException( "Failed connecting to the MySQL database" .
                "(error #". mysql_errno( $this->db ).": " . mysql_error( $this->db ) );

        if ( !mysql_select_db( $this->name, $this->db ) )
            throw new RuntimeException( "Failed selecting the MySQL database" .
                "(error #". mysql_errno( $this->db ).": " . mysql_error( $this->db ) );

        if ( !mysql_set_charset( $this->charset, $this->db ) )
            throw new RuntimeException( "Failed to set database charset to '$this->charset' " .
                "(error #". mysql_errno( $this->db ).": " . mysql_error( $this->db ) );
    }

    public function fetchFileMetadata( $filepath )
    {
        $sql = "SELECT * FROM ezdbfile WHERE name_hash = MD5('$filepath')" ;
        if ( !$res = mysql_query( $sql, $this->db ) )
            throw new RuntimeException( "Failed to fetch file metadata for '$filepath' " .
                "(error #". mysql_errno( $this->db ).": " . mysql_error( $this->db ) );

        if ( mysql_num_rows( $res ) == 0 )
            return false;

        $metadata = mysql_fetch_assoc( $res );
        mysql_free_result( $res );
        return $metadata;
    }

    public function passthrough( $filepath, $filesize, $offset = false, $length = false)
    {
        if ( $offset !== false )
            throw new UnexpectedValueException( "HTTP Range is not supported by " . __CLASS__ );

        if ( !$res = mysql_query( "SELECT filedata FROM ezdbfile_data WHERE name_hash=MD5('$filepath') ORDER BY offset ASC", $this->db ) )
            throw new RuntimeException( "Unable to open file data for '$filepath' " .
                "(error #". mysql_errno( $this->db ).": " . mysql_error( $this->db ) );
        while ( $row = mysql_fetch_row( $res ) )
            echo $row[0];
        mysql_free_result( $res );
    }

    public function close()
    {
        mysql_close( $this->db );
        unset( $this->db );
    }
}

ezpClusterGateway::setGatewayClass( 'ezpDbMySQLClusterGateway' );

<?php
/**
 * SOFTWARE NAME: autostatus
 * SOFTWARE RELEASE: 0.2
 * COPYRIGHT NOTICE: Copyright (C) 2009-2011 Damien POBEL
 * SOFTWARE LICENSE: GNU General Public License v2.0
 * NOTICE: >
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of version 2.0  of the GNU General
 *   Public License as published by the Free Software Foundation.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of version 2.0 of the GNU General
 *   Public License along with this program; if not, write to the Free
 *   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *   MA 02110-1301, USA.
 */

/**
 * eZPersistent object implementation used to store
 * updates launched by autostatus extension
 * 
 * @uses eZPersistentObject
 * @author Damien Pobel
 */
class statusUpdateEvent extends eZPersistentObject
{
    const NORMAL    = 0;
    const EXCEPTION = 1;
    const ERROR     = 2;

    static $statusText = array( self::NORMAL => 'normal',
                                self::EXCEPTION => 'exception',
                                self::ERROR => 'error' );

    protected $ID;
    protected $WorkflowEventID;
    protected $UserID;
    protected $ContentObjectID;
    protected $StatusMessage;
    protected $Created;
    protected $Modified;
    protected $ErrorMessage;
    protected $Status;

    static function definition()
    {
        static $definition = array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true ),
                                                       'event_id' => array( 'name' => 'WorkflowEventID',
                                                                            'datatype' => 'integer',
                                                                            'default' => 0,
                                                                            'required' => true ),
                                                       'user_id' => array( 'name' => 'UserID',
                                                                           'datatype' => 'integer',
                                                                           'default' => 0,
                                                                           'required' => true ),
                                                       'contentobject_id' => array( 'name' => 'ContentObjectID',
                                                                                    'datatype' => 'integer',
                                                                                    'default' => 0,
                                                                                    'required' => true ),
                                                       'message' => array( 'name' => 'StatusMessage',
                                                                           'datatype' => 'string',
                                                                           'default' => '',
                                                                           'required' => true ),
                                                       'created' => array( 'name' => 'Created',
                                                                           'datatype' => 'integer',
                                                                           'default' => 0,
                                                                           'required' => true ),
                                                       'modified' => array( 'name' => 'Modified',
                                                                            'datatype' => 'integer',
                                                                            'default' => 0,
                                                                            'required' => true ),
                                                       'status' => array( 'name' => 'Status',
                                                                          'datatype' => 'integer',
                                                                          'default' => 0,
                                                                          'required' => true ),
                                                       'error_msg' => array( 'name' => 'ErrorMessage',
                                                                             'datatype' => 'string',
                                                                             'default' => '',
                                                                             'required' => true ) ),
                                    'keys' => array( 'id' ),
                                    'increment_key' => 'id',
                                    'function_attributes' => array( 'event' => 'fetchEvent',
                                                                    'user' => 'fetchUser',
                                                                    'object' => 'fetchContentObject',
                                                                    'status_text' => 'statusText',
                                                                    'is_error' => 'isError' ),
                                    'class_name' => 'statusUpdateEvent',
                                    'name' => 'statusupdateevent' );
        return $definition;
    }

    function fetchUser()
    {
        return eZUser::fetch( $this->UserID );
    }

    function fetchContentObject()
    {
        return eZContentObject::fetch( $this->ContentObjectID );
    }

    function fetchEvent()
    {
        $eventID = $this->attribute( 'event_id' );
        return eZWorkflowEvent::fetch( $eventID );
    }

    function isError()
    {
        return ( $this->Status != self::NORMAL );
    }

    function statusText()
    {
        return self::$statusText[$this->Status];
    }

    /**
     * Create an statusUpdateEvent instance 
     * 
     * @param int $eventID workflow event id
     * @param string $message message used to update status
     * @param string $errorMsg error message
     * @param int $status status code
     * @param int $userID user id that sends the update
     * @param int $contentObjectID content object id
     * @static
     * @access public
     * @return statusUpdateEvent
     */
    static function create( $eventID, $message, $errorMsg, $status, $userID, $contentObjectID )
    {
        $row = array( 'event_id' => $eventID,
                      'created' => time(),
                      'modified' => time(),
                      'message' => $message,
                      'error_msg' => (string) $errorMsg,
                      'status' => $status,
                      'user_id' => $userID,
                      'contentobject_id' => $contentObjectID );
        return new statusUpdateEvent( $row );
    }

    static function fetch( $id )
    {
        return eZPersistentObject::fetchObject( self::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                true );
    }

    static function fetchList( $conditions, $offset, $limit )
    {
        $result = eZPersistentObject::fetchObjectList( self::definition(),
                                                       null, // field filters
                                                       $conditions,
                                                       array( 'modified' => 'desc' ),
                                                       array( 'limit' => $limit, 'offset' => $offset ),
                                                       true );

        return $result;
    }

    static function fetchListCount( $conditions = array() )
    {
        return eZPersistentObject::count( self::definition(), $conditions );
    }

    function store( $fieldFilters = null )
    {
        if ( $this->ID )
        {
            $this->Modified = time();
        }
        parent::store( $fieldFilters );
    }

}



?>

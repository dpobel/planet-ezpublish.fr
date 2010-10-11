<?php
/**
 * File containing PHP session handler
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 4.4.0
 * @package lib
 */

/** PHP session handler class
 * Does not register it self as opposed to most other handler, as the point is to let PHP handle most things
 *
 * @since 4.4
 * @package lib
 * @subpackage ezsession
 */
class ezpSessionHandlerPHP extends ezpSessionHandler
{
    /**
     * reimp (Does nothing, lets php handle sessions)
     * Does set gc_maxlifetime to SessionTimeout to make sure timeout works like DB handler
     */
    public function setSaveHandler()
    {
        $ini = eZINI::instance();
        if ( $ini->hasVariable('Session', 'SessionTimeout') && $ini->variable('Session', 'SessionTimeout') )
        {
            ini_set("session.gc_maxlifetime", $ini->variable('Session', 'SessionTimeout') );
        }
        return true;
    }

    /**
     *  reimp (not used in this handler)
     */
    public function read( $sessionId )
    {
        return false;
    }

    /**
     *  reimp (not used in this handler)
     */
    public function write( $sessionId, $sessionData )
    {
        return false;
    }

    /**
     *  reimp (not used in this handler)
     *
     *  So callbacks on this function is not called, this is a known limitation.
     *  Either make sure your data does not depend on session id, or make sure it is cleanup in session_gc.php (cronjob).
     */
    public function destroy( $sessionId )
    {
        return false;
    }

    /**
     *  reimp (Only uses php and callbacks)
     */
    public function regenerate( $updateBackendData = true )
    {
        $oldSessionId = session_id();
        session_regenerate_id();

        if ( $updateBackendData )
        {
            $db = eZDB::instance();
            $escOldKey = $db->escapeString( $oldSessionId );
            $escNewKey = $db->escapeString( session_id() );
            $escUserID = $db->escapeString( eZSession::userID() );
            eZSession::triggerCallback( 'regenerate_pre', array( $db, $escNewKey, $escOldKey, $escUserID ) );
            eZSession::triggerCallback( 'regenerate_post', array( $db, $escNewKey, $escOldKey, $escUserID ) );
        }
        return true;
    }

   /**
     * reimp (not used in this handler)
     */
    public function gc( $maxLifeTime )
    {
        $db = eZDB::instance();
        eZSession::triggerCallback( 'gc_pre', array( $db, $maxLifeTime ) );
        eZSession::triggerCallback( 'gc_post', array( $db, $maxLifeTime ) );
        return false;
    }

   /**
     * reimp (not used in this handler)
     */
    public function cleanup()
    {
        $db = eZDB::instance();
        eZSession::triggerCallback( 'cleanup_pre', array( $db ) );
        eZSession::triggerCallback( 'cleanup_post', array( $db ) );
        return true;
    }

    /**
     * reimp (not used in this handler)
     */
    public function deleteByUserIDs( array $userIDArray )
    {
    }

   /**
     * reimp (this handler does not use db)
     */
    static public function hasBackendAccess()
    {
        return false;
    }

}
?>

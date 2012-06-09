<?php
/**
 * File containing the ezxFormToken class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 1.1.0
 * @package ezformtoken
 */

/**
 * This class takes listens to interal kernel events in eZ Publish to validate forms using pr session tokens
 *
 * @See settings/site.ini.append.php for events used.
 * @See doc/Readme.rst for info about extension and about how to modify your ajax code to work with it.
 *
 * @internal
 * @since 4.5.0
 * @version 1.1.0
 * @package ezformtoken
 */

class ezxFormToken
{
    const SESSION_KEY = __CLASS__;
    
    const FORM_FIELD = 'ezxform_token';

    const REPLACE_KEY = '@$ezxFormToken@';
    
    /**
     * request/input event listener
     * Checks if form token is valid if user is logged in.
     *
     * @param eZURI $uri
     */
    static public function input( eZURI $uri )
    {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' && empty( $_POST ) )
        {
            eZDebugSetting::writeDebug( 'ezformtoken', 'Input not protected (not POST)', __METHOD__ );
            return null;
        }

        if ( !self::shouldProtectUser() )
        {
            eZDebugSetting::writeDebug( 'ezformtoken', 'Input not protected (not logged in user)', __METHOD__ );
            return null;
        }

        /* Not a safe assumtion, just kept for reference
        if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] )
          && trim( strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) === 'xmlhttprequest' )
        {
            eZDebugSetting::writeDebug( 'ezformtoken', 'Input not protected (ajax request)', __METHOD__ );
            return null;
        }*/

        if ( empty( $_POST[self::FORM_FIELD] ) )
            throw new Exception( 'Missing token from Form', 404 );

        
        if ( $_POST[self::FORM_FIELD] !== self::getToken() )
            throw new Exception( 'Wrong token found in Form!', 404 );
            
        eZDebugSetting::writeDebug( 'ezformtoken', 'Input validated, token verified and was correct', __METHOD__ );
    }

    /**
     * response/output event filter
     * Appends tokens to  POST forms if user is logged in.
     * 
     * @param string $templateResult ByRef
     */
    static public function output( $templateResult )
    {
        if ( !self::shouldProtectUser() )
        {
            eZDebugSetting::writeDebug( 'ezformtoken', 'Output not protected (not logged in user)', __METHOD__ );
            return $templateResult;
        }

        // We only rewrite pages served with an html/xhtml content type
        $sentHeaders = headers_list();
        foreach ( $sentHeaders as $header )
        {
            // Search for a content-type header that is NOT HTML
            // Note the Content-Type header will not be included in
            // headers_list() unless it has been explicitly set from PHP.
            if (stripos( $header, 'Content-Type:' ) === 0 &&
                strpos( $header, 'text/html' ) === false &&
                strpos( $header, 'application/xhtml+xml' ) === false   )
           {
               eZDebugSetting::writeDebug( 'ezformtoken', 'Output not protected (Content-Type is not html/xhtml)', __METHOD__ );
               return $templateResult;
            }
        }

        $token = self::getToken();
        $field = self::FORM_FIELD;
        $replaceKey = self::REPLACE_KEY;
        $tag = "\n<span style='display:none;' id=\"{$field}_js\" title=\"{$token}\"></span>\n";
        $input = "\n<input type=\"hidden\" name=\"{$field}\" value=\"{$token}\" />\n";
               
        eZDebugSetting::writeDebug( 'ezformtoken', 'Output protected (all forms will be modified)', __METHOD__ );

        $templateResult = preg_replace(
            '/(<body[^>]*>)/i',
            '\\1' . $tag,
            $templateResult
        );

        $templateResult = preg_replace(
            '/(<form\W[^>]*\bmethod=(\'|"|)POST(\'|"|)\b[^>]*>)/i',
            '\\1' . $input,
            $templateResult
        );

        return str_replace( $replaceKey, $token, $templateResult );
    }
    
    /**
     * session/regenerate event handler, clears form token when users
     * logs out / in.
     */
    static public function reset()
    {
        eZDebugSetting::writeDebug( 'ezformtoken', 'Reset form token', __METHOD__ );
        eZSession::unsetkey( self::SESSION_KEY, false );
    }

    /**
     * Gets the user token from session if it exists or create+store
     * it in session.
     *
     * @return string|null
     */
    static public function getToken()
    {
        if ( eZSession::issetkey( self::SESSION_KEY ) )
            return eZSession::get( self::SESSION_KEY );

        $token = md5( uniqid( self::SESSION_KEY, true ) );
        eZSession::set( self::SESSION_KEY, $token );
        return $token;
    }

    /**
     * Figures out if current user should be protected or not
     * based on if (s)he has a session and is logged in.
     *
     * @return bool
     */
    static protected function shouldProtectUser()
    {
        if ( !eZSession::hasStarted() )
            return false;

        if ( !eZUser::currentUser()->isLoggedIn() )
            return false;

        return true;
    }
}

?>

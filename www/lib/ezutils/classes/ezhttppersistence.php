<?php
/**
 * File containing the eZHTTPPersistence class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package lib
 */

/**
 * Object persistence using HTTP post variables
 *
 * This class allows objects or data to exist between page views.
 * It can read HTTP post variables and set them in existing objects
 * to override data. This is useful if you want to keep changes in a
 * page but don't want to store the changes in a DB. It also makes it
 * easier to fetch the changes by the user before an object is stored.
 */
class eZHTTPPersistence
{
    /**
     * Initializes the class.
     */
    public function __construct()
    {
    }

    /**
     * Fetches the HTTP post variables using the base name $base_name and stores
     * them in the object $objects, if $is_array is true then $objects is assumed
     * to be an array and all objects are updated.
     *
     * @param string $base_name Base name for HTTP POST variables
     * @param array $def Definition for $objects, uses the same syntax as {@link eZPersistentObject}
     * @param object|object[] Single object or array of objects having the same definition provided in $def
     * @param eZHTTPTool
     * @param bool $is_array If true, $objects is assumed to be an array
     * @param string|false $indexField Field name as defined in $def. If provided, will be used to fetch HTTP variables as index.
     * @return void
     */
    static function fetch( $base_name, array $def, $objects, eZHTTPTool $http, $is_array, $indexField = false )
    {
        if ( $is_array )
        {
            for ( $i = 0, $iMax = count( $objects ); $i < $iMax; ++$i )
            {
                $object = $objects[$i];
                $index = is_string( $indexField ) ? $indexField : $i;
                eZHTTPPersistence::fetchElement( $base_name, $def, $object, $http, $index );
            }
        }
        else
        {
            eZHTTPPersistence::fetchElement( $base_name, $def, $objects, $http, false );
        }
    }

    /**
     * Helper function for {@link eZHTTPPersistence::fetch()}
     *
     * @param string $base_name
     * @param array $def Definition for $object, uses the same syntax as {@link eZPersistentObject}
     * @param object $object
     * @param eZHTTPTool $http
     * @param int|string|false $index Index in HTTP POST data corresponding to $object.
     *                                Set as string will make use of corresponding field in $def
     *                                Set to false if posted data is not an array.
     * @see eZHTTPPersistence::fetch()
     * @return void
     */
    static function fetchElement( $base_name, array $def, $object, eZHTTPTool $http, $index )
    {
        $fields = $def["fields"];
        $keys = $def["keys"];
        foreach ( $fields as $field_name => $field_member )
        {
            if ( !in_array( $field_name, $keys ) )
            {
                $post_var = $base_name . "_" . $field_name;
                if ( $http->hasPostVariable( $post_var ) )
                {
                    $post_value = $http->postVariable( $post_var );
                    if ( $index === false )
                    {
                        $object->setAttribute( $field_name, $post_value );
                    }
                    else if ( is_string( $index ) )
                    {
                        $object->setAttribute( $field_name, $post_value[$object->attribute( $index )] );
                    }
                    else
                    {
                        $object->setAttribute( $field_name, $post_value[$index] );
                    }
                }
            }
        }
    }

    /**
     * This function has some serious flaws and will be removed in a future release
     * Goes trough all fields defined in \a $def and tries to find a post variable
     * which is named \a $base_name, field name and "checked" with _ between items.
     * If the post variable is an array the id of the current object is matched against
     * that array, if one is found the matched field is set to be true otherwise false.
     * If no post variable was found with that signature the field is ignored.
     * Example of name:
     * <code>
     *   In the HTML code use:<br/>
     *   <input type="checkbox" name="ContentClassAttribute_is_searchable_checked[]" value="some_id" />
     * </code>
     *
     * @deprecated
     * @param string $base_name
     * @param array $def
     * @param object|object[] $objects
     * @param eZHTTPTool $http
     * @param bool $is_array
     */
    static function handleChecked( $base_name, array $def, $objects, eZHTTPTool $http, $is_array = true )
    {
        if ( $is_array )
        {
            foreach( $objects as $object )
            {
                eZHTTPPersistence::handleCheckedElement( $base_name, $def, $object, $http );
            }
        }
        else
        {
            eZHTTPPersistence::handleCheckedElement( $base_name, $def, $objects, $http );
        }
    }

    /**
     * Helper function for handleChecked().
     *
     * @deprecated This function has some serious flaws and will be removed in a future release
     * @param string $base_name
     * @param array $def
     * @param object $object
     * @param eZHTTPTool $http
     */
    static function handleCheckedElement( $base_name, array $def, $object, eZHTTPTool $http )
    {
        $fields = $def["fields"];
        $keys = $def["keys"];
        $id = $object->attribute( "id" );
        foreach ( $fields as $field_name => $field_member )
        {
            if ( !in_array( $field_name, $keys ) )
            {
                $post_var = $base_name . "_" . $field_name . "_checked";
                if ( $http->hasPostVariable( $post_var ) or $field_name == "is_searchable" or $field_name == "is_required"   )
                {
                    $value = false;
                    $post_value = $http->postVariable( $post_var );
                    if ( is_array( $post_value ) &&
                         in_array( $id, $post_value ) )
                    {
                        $value = true;
                    }
                    else
                    {
                         $value = false;
                    }
                    $object->setAttribute( $field_name, $value );
                }
            }
        }
    }

    /**
     * Loops over the HTTP post variables with $base_name as the base.
     * It examines the HTTP post variable $base_name "_" $cond "_checked"
     * which should contain an array of ids. The ids are then matched against
     * the objects attribute $cond. If they match the object is moved to the
     * $rejects array otherwise the $keepers array.
     *
     * @param string $base_name
     * @param object[] $objects
     * @param eZHTTPTool $http
     * @param $cond
     * @param $keepers
     * @param $rejects
     * @return boolean
     */
    static function splitSelected( $base_name, $objects, eZHTTPTool $http, $cond, &$keepers, &$rejects )
    {
        $keepers = array();
        $rejects = array();
        $post_var = $base_name . "_" . $cond . "_checked";
        if ( $http->hasPostVariable( $post_var ) )
        {
            $checks = $http->postVariable( $post_var );
        }
        else
        {
            return false;
        }
        foreach( $objects as $object )
        {
            if ( $object->hasAttribute( $cond ) )
            {
                $val = $object->attribute( $cond );
                if ( in_array( $val, $checks ) )
                {
                    $rejects[] = $object;
                }
                else
                {
                    $keepers[] = $object;
                }
            }
            else
            {
                $keepers[] = $object;
            }
        }
        return true;
    }
}
?>

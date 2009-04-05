<?php
/**
 * File containing the ezcCacheStorageOptions class.
 *
 * @package Cache
 * @version 1.4
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Option class for the ezcCacheStorage class.
 * Instances of this class store the option of ezcCacheStorage implementations.
 *
 * @property int    $ttl       The time to live of cache entries.
 * @property string $extension The (file) extension to use for the storage items.
 *
 * @package Cache
 * @version 1.4
 */
class ezcCacheStorageOptions extends ezcBaseOptions
{
    /**
     * Constructs a new options object.
     *
     * It also sets the default values of the format property
     *
     * @param array(string=>mixed) $options The initial options to set.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    public function __construct( $options = array() )
    {
        $this->properties['ttl'] = 86400;
        $this->properties['extension'] = '.cache';
        parent::__construct( $options );
    }

    /**
     * Sets an option.
     * This method is called when an option is set.
     * 
     * @param string $key  The option name.
     * @param mixed $value The option value.
     * @ignore
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "extension":
                if ( !is_string( $value ) || strlen( $value ) < 1 )
                {
                    throw new ezcBaseValueException( $key, $value, "string, size > 0" );
                }
                break;
            case "ttl":
                if ( !is_int( $value ) && $value !== false )
                {
                    throw new ezcBaseValueException( $key, $value, "int > 0 or false" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $key );
        }
        $this->properties[$key] = $value;
    }
}


?>

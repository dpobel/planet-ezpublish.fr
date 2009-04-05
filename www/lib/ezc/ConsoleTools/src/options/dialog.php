<?php
/**
 * This file contains the ezcConsoleDialogOptions class.
 *
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access public
 */

/**
 * Basic options class for ezcConsoleDialog implementations.
 * 
 * @property ezcConsoleDialogValidator $validator
 *           The validator to use with this dialog.
 * @property string $format
 *           The output format for the dialog.
 * @package ConsoleTools
 * @version 1.5
 */
class ezcConsoleDialogOptions extends ezcBaseOptions
{
    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        "format"    => "default",
        "validator" => null
    );

    /**
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue The value for the property.
     *
     * @throws ezcBasePropertyPermissionException
     *         If the property you try to access is read-only.
     * @throws ezcBasePropertyNotFoundException 
     *         If the the desired property is not found.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "format":
                if ( is_string( $propertyValue ) === false || strlen( $propertyValue ) < 1 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "string, length > 0" );
                }
                break;
            case "validator":
                if ( ( $propertyValue instanceof ezcConsoleDialogValidator ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "ezcConsoleDialogValidator" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>

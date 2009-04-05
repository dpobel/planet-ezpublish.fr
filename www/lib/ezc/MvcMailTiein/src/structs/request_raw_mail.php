<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.0
 * @filesource
 * @package MvcMailTiein
 */

/**
 * Class that encapsulates a parsed e-mail structure.
 *
 * @package MvcMailTiein
 * @version 1.0
 */
class ezcMvcMailRawRequest extends ezcBaseStruct
{
    /**
     * Contains a reference to a parsed email structure
     *
     * @var ezcMail
     */
    public $mail;

    /**
     * Constructs a new ezcMvcMailRawRequest.
     *
     * @param ezcMail $mail
     */
    public function __construct( $mail = null )
    {
        $this->mail = $mail;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcMvcMailRawRequest
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcMailRawRequest( $array['mail'] );
    }
}
?>

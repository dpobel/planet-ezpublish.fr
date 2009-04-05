<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.0
 * @filesource
 * @package MvcTools
 */

/**
 * This struct contains content meta-data
 *
 * @package MvcTools
 * @version 1.0
 */
class ezcMvcResultContent extends ezcBaseStruct
{
    /**
     * The content's language
     *
     * @var string
     */
    public $language;

    /**
     * The content's mime-type
     *
     * @var string
     */
    public $type;

    /**
     * The character set
     *
     * @var string
     */
    public $charset;

    /**
     * The content "encoding" (gzip, etc).
     *
     * @var string
     */
    public $encoding;

    /**
     * Constructs a new ezcMvcResultContent.
     *
     * @param string $language
     * @param string $type
     * @param string $charset
     * @param string $encoding
     */
    public function __construct( $language = '', $type = '', 
        $charset = '', $encoding = '' )
    {
        $this->language = $language;
        $this->type = $type;
        $this->charset = $charset;
        $this->encoding = $encoding;
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
     * @return ezcMvcResultContent
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcResultContent( $array['language'], $array['type'], 
            $array['charset'], $array['encoding'] );
    }
}
?>

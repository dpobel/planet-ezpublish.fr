<?php
/**
 * File containing the eZPlainXMLOutput class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

class eZPlainXMLOutput extends eZXMLOutputHandler
{
    function eZPlainXMLOutput( &$xmlData, $aliasedType )
    {
        $this->eZXMLOutputHandler( $xmlData, $aliasedType );
    }

    function &outputText()
    {
        $retText = "<pre>" . htmlspecialchars( $this->xmlData() ) . "</pre>";
        return $retText;
    }
}

?>

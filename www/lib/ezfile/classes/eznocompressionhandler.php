<?php
/**
 * File containing the eZNoCompressionHandler class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package lib
 */

/*!
  \class eZNoCompressionHandler eznocompressionhandler.php
  \brief Does no compression at all

*/

class eZNoCompressionHandler extends eZCompressionHandler
{
    /*!
     See eZCompressionHandler::eZCompressionHandler
    */
    function eZNoCompressionHandler()
    {
        $this->eZCompressionHandler( 'No compression', 'no' );
    }
}

?>

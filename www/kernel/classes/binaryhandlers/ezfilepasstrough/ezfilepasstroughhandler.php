<?php
//
// Definition of eZFilePasstroughHandler class
//
// Created on: <30-Apr-2002 16:47:08 bf>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

/*!
  \class eZFilePasstroughHandler ezfilepasstroughhandler.php
  \ingroup eZBinaryHandlers
  \deprecated Use eZFilePassthroughHandler instead
  \brief Handles file downloading by passing the file trough PHP

*/
//include_once( "kernel/classes/datatypes/ezbinaryfile/ezbinaryfile.php" );
//include_once( "kernel/classes/ezbinaryfilehandler.php" );

class eZFilePasstroughHandler extends eZFilePassthroughHandler
{
    const HANDLER_ID = 'ezfilepasstrough';

    function eZFilePasstroughHandler()
    {
        eZDebug::writeWarning( 'eZFilePasstroughHandler is deprecated, use eZFilePassthroughHandler instead. ' .
                                 'Change file.ini [BinaryFileSettings] Handler to ezfilepassthrough',
                               'Usage of deprecated class' );
        $this->eZBinaryFileHandler( self::HANDLER_ID, "PHP passthrough", eZBinaryFileHandler::HANDLE_DOWNLOAD );
    }
}

?>

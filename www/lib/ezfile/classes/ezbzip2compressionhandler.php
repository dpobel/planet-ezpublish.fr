<?php
//
// Definition of eZBZIP2Handler class
//
// Created on: <13-Aug-2003 16:20:19 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.2.0
// BUILD VERSION: 24182
// COPYRIGHT NOTICE: Copyright (C) 1999-2009 eZ Systems AS
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

/*! \file
*/

/*!
  \class eZBZIP2Handler ezbzip2handler.php
  \brief Handles files compressed with bzip2


NOTE: This is not done yet.
*/

class eZBZIP2Handler extends eZCompressionHandler
{
    /*!
     See eZCompressionHandler::eZCompressionHandler
    */
    function eZBZIP2Handler()
    {
        $this->eZCompressionHandler();
    }

    function doOpen( $filename, $mode )
    {
    }

    function doClose()
    {
    }

    function doRead( $uncompressedLength = false )
    {
    }

    function doWrite( $data, $uncompressedLength = false )
    {
    }

    function doFlush()
    {
    }

    function compress( $source )
    {
    }

    function decompress( $source )
    {
    }

    function error()
    {
    }

    function errorString()
    {
    }

    function errorNumber()
    {
    }

    /// \privatesection
    public $WorkFactor;
    public $BlockSize;
    public $SmallDecompress;
}

?>

<?php
//
// Definition of eZTextDiff class
//
// <creation-tag>
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

/*! \file eztextdiff.php
  eZTextDiff class
*/

/*!
  \class eZTextDiff eztextdiff.php
  \ingroup eZDiff
  \brief eZDiff contains actual changes detected on plain text.

  eZTextDiff holds container structures for viewing and accessing detected differences
  in an plain text.
*/

//include_once( 'lib/ezdiff/classes/ezdiffcontent.php' );

class eZTextDiff extends eZDiffContent
{
    /*!
      Constructor
    */
    function eZTextDiff()
    {
    }
}
?>

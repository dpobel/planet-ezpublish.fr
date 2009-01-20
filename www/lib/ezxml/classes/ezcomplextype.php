<?php
//
// $Id$
//
// Definition of eZComplexType class
//
// B�rd Farstad <bf@ez.no>
// Created on: <14-Feb-2002 10:22:09 bf>
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
  \class eZComplexType
  \ingroup eZXML
  \brief eZComplexType implements XML schema complex type

*/

//include_once( "lib/ezxml/classes/ezelementtype.php" );

class eZComplexType extends eZElementType
{
    /*!
      Creates a new complex type object
    */
    function eZComplexType()
    {

    }

    /*!
      Returns the type name.
    */
    function isA()
    {
        return "complexType";
    }


}

?>

<?php
//
// Definition of eZSetupFunctionCollection class
//
// Created on: <02-Nov-2004 13:23:10 dl>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.3.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
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
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file
*/

/*!
  \class eZSetupFunctionCollection ezsetupfunctioncollection.php
  \brief The class eZSetupFunctionCollection does

*/

class eZSetupFunctionCollection
{
    /*!
     Constructor
    */
    function eZSetupFunctionCollection()
    {
    }


    function fetchFullVersionString()
    {
        return array( 'result' => eZPublishSDK::version() );
    }

    function fetchMajorVersion()
    {
        return array( 'result' => eZPublishSDK::majorVersion() );
    }

    function fetchMinorVersion()
    {
        return array( 'result' => eZPublishSDK::minorVersion() );
    }

    function fetchRelease()
    {
        return array( 'result' => eZPublishSDK::release() );

    }

    function fetchState()
    {
        return array( 'result' => eZPublishSDK::state() );
    }

    function fetchIsDevelopment()
    {
        return array( 'result' => eZPublishSDK::developmentVersion() ? true : false );
    }

    function fetchRevision()
    {
        return array( 'result' => eZPublishSDK::revision() );
    }

    function fetchDatabaseVersion( $withRelease = true )
    {
        return array( 'result' => eZPublishSDK::databaseVersion( $withRelease ) );
    }

    function fetchDatabaseRelease()
    {
        return array( 'result' => eZPublishSDK::databaseRelease() );
    }
}

?>

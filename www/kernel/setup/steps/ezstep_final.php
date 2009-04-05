<?php
//
// Definition of eZStepFinal class
//
// Created on: <13-Aug-2003 14:09:47 kk>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.1.0
// BUILD VERSION: 23234
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
require_once( "kernel/common/i18n.php" );

/*!
  \class eZStepFinal ezstep_final.php
  \brief The class eZStepFinal does

*/

class eZStepFinal extends eZStepInstaller
{
    /*!
     Constructor
    */
    function eZStepFinal( $tpl, $http, $ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList,
                                'final', 'Final' );
    }

    function processPostData()
    {
        return true; // Last step, but always proceede
    }

    function init()
    {
        return false; // Always show
    }

    function display()
    {
        $siteType = $this->chosenSiteType();

        $siteaccessURLs = $this->siteaccessURLs();

        $siteType['url'] = $siteaccessURLs['url'];
        $siteType['admin_url'] = $siteaccessURLs['admin_url'];

        $customText = isset( $this->PersistenceList['final_text'] ) ? $this->PersistenceList['final_text'] : '';

        $this->Tpl->setVariable( 'site_type', $siteType );

        $this->Tpl->setVariable( 'custom_text', $customText );

        $this->Tpl->setVariable( 'setup_previous_step', 'Final' );
        $this->Tpl->setVariable( 'setup_next_step', 'Final' );

        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( 'design:setup/init/final.tpl' );
        $result['path'] = array( array( 'text' => ezi18n( 'design/standard/setup/init',
                                                          'Finished' ),
                                        'url' => false ) );
        return $result;

    }
}

?>

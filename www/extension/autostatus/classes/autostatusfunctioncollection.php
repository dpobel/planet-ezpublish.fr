<?php
/**
 * SOFTWARE NAME: autostatus
 * SOFTWARE RELEASE: 0.2
 * COPYRIGHT NOTICE: Copyright (C) 2009-2011 Damien POBEL
 * SOFTWARE LICENSE: GNU General Public License v2.0
 * NOTICE: >
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of version 2.0  of the GNU General
 *   Public License as published by the Free Software Foundation.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of version 2.0 of the GNU General
 *   Public License along with this program; if not, write to the Free
 *   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *   MA 02110-1301, USA.
 */

/**
 * Provides method used by fetch function of autostatus module
 */
class autostatusFunctionCollection
{

    /**
     * Return the list of the available networks
     * 
     * @access public
     * @return array( 'result' => array() )
     */
    function networkList()
    {
        $ini = eZINI::instance( 'autostatus.ini' );
        $identifierArray = $ini->variable( 'AutoStatusSettings', 'SocialNetworks' );
        $networkObjects = array();
        foreach( $identifierArray as $identifier )
        {
            $object = autostatusSocialNetwork::fetchByIdentifier( $identifier );
            if ( $object !== null )
            {
                $networkObjects[] = $object;
            }
        }
        return array( 'result' => $networkObjects );
    }


}


?>

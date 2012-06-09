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

class autostatusInfo
{
    static function info()
    {
        return array( 'Name' => 'Auto Status',
                      'Version' => '0.2',
                      'Info_url' => 'http://projects.ez.no/autostatus',
                      'Copyright' => 'Copyright (C) 2009-2011 Damien Pobel and contributors',
                      'License' => 'GNU General Public License v2.0',
                      '3rdparty_software' => array( 'name' => 'Zend Framework',
                                                    'version' => '1.11.7',
                                                    'copyright' => 'Zend Technologies USA, Inc.',
                                                    'license' => 'Zend Framework license',
                                                    'info_url' => 'http://framework.zend.com/' ) );
    }

}


?>

<?php
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Online Editor
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

class ezoeInfo
{
    static function info()
    {
        $eZCopyrightString = 'Copyright (C) 1999-2010 eZ Systems AS';

        return array( 'Name'      => '<a href="http://projects.ez.no/ezoe">eZ Online Editor</a> extension',
                      'Version'   => '5.1-0',
                      'Copyright' => $eZCopyrightString,
                      'License'   => 'GNU General Public License v2.0',
                      'Includes the following third-party software' => array( 'Name' => 'TinyMce Javascript HTML WYSIWYG editor',
                                                                              'Version' => '3.2.7',
                                                                              'Copyright' => 'Copyright (C) 2004-2010, Moxiecode Systems AB, All rights reserved.',
                                                                              'License' => 'GNU Lesser General Public License v2.1',),
                      'Includes the following library'              => array( 'Name' => 'eZ Core, tiny javascript library for ajax and stuff',
                                                                              'Version' => '0.96',
                                                                              'Copyright' => $eZCopyrightString,
                                                                              'License' => 'Licensed under the MIT License',),
                      'Includes the following third-party icons'    => array( 'Name' => 'Tango Icon theme',
                                                                              'Version' => '0.8.90',
                                                                              'Copyright' => 'Copyright (C) 1999-2010 http://tango.freedesktop.org/Tango_Icon_Library',
                                                                              'License' => 'Creative Commons Attribution-ShareAlike 2.5',)
                    );
    }
}

?>

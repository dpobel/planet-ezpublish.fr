<?php
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ JSCore
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

class ezjscoreInfo
{
    static function info()
    {
        $eZCopyrightString = 'Copyright (C) 1999-2010 eZ Systems AS';

        return array( 'Name'      => '<a href="http://projects.ez.no/ezjscore">eZ JSCore</a> extension',
                      'Version'   => '1.1-0',
                      'Copyright' => $eZCopyrightString,
                      'License'   => 'GNU General Public License v2.0',
                      'Includes the following third-party software' => array( 'Name' => 'YUI',
                                                                              'Version' => "3.0.0 and 2.7.0",
                                                                              'Copyright' => 'Copyright (c) 2009, Yahoo! Inc. All rights reserved.',
                                                                              'License' => 'Licensed under the BSD License',),
                      'Includes the following third-party software (2)' => array( 'Name' => 'jQuery',
                                                                              'Version' => "1.4.2",
                                                                              'Copyright' => 'Copyright (c) 2009 John Resig',
                                                                              'License' => 'Dual licensed under the MIT and GPL licenses',),
                      'Includes the following third-party software (3)' => array( 'Name' => 'JSMin (jsmin-php)',
                                                                              'Version' => "1.1.1",
                                                                              'Copyright' => '2002 Douglas Crockford <douglas@crockford.com> (jsmin.c), 2008 Ryan Grove <ryan@wonko.com> (PHP port)',
                                                                              'License' => 'Licensed under the MIT License',),
                    );
    }
}

?>

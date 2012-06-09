<?php
//
// $Id: ezinfo.php 21 2011-06-22 20:24:05Z dpobel $
// $HeadURL: http://svn.projects.ez.no/ezclasslists/tags/ezclasslists_1_2/ezclasslists/ezinfo.php $
//
// Created on: <30-May-2009 16:57 damien pobel>
//
// SOFTWARE NAME: eZ Class Lists
// SOFTWARE RELEASE: 1.2
// COPYRIGHT NOTICE: Copyright (C) 1999-2011 Damien POBEL
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

class ezclasslistsInfo
{
    static function info()
    {
        return array( 'Name' => "<a href=\"http://projects.ez.no/ezclasslists\">eZ Class lists</a> extension",
                      'Version' => "1.2",
                      'Copyright' => "Copyright (C) 1999-2011 Damien POBEL",
                      'License' => "GNU General Public License v2.0"
                      );
    }
}
?>

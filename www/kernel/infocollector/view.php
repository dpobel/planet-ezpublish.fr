<?php
//
// Created on: <13-Feb-2005 03:13:00 bh>
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



$http = eZHTTPTool::instance();
$Module = $Params['Module'];
$collectionID = $Params['CollectionID'];

$collection = false;
$object = false;

if( is_numeric( $collectionID ) )
{
    $collection = eZInformationCollection::fetch( $collectionID );
}

if( !$collection )
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$object = eZContentObject::fetch( $collection->attribute( 'contentobject_id' ) );

if( !$object )
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$objectID   = $collection->attribute( 'contentobject_id' );
$objectName = $object->attribute( 'name' );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'module', $Module );
$tpl->setVariable( 'collection', $collection );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:infocollector/view.tpl' );
$Result['path'] = array( array( 'url' => '/infocollector/overview',
                                'text' => ezpI18n::tr( 'kernel/infocollector', 'Collected information' ) ),
                         array( 'url' => '/infocollector/collectionlist/' . $objectID,
                                'text' => $objectName ),
                         array( 'url' => false,
                                'text' => $collectionID ) );

?>

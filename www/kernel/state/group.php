<?php
//
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.2.0
// BUILD VERSION: 24182
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

$Module = $Params['Module'];
$GroupIdentifier = $Params['GroupIdentifier'];
$LanguageCode = $Params['Language'];

$group = eZContentObjectStateGroup::fetchByIdentifier( $GroupIdentifier );

if ( !is_object( $group ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

require_once 'kernel/common/template.php';

$tpl = templateInit();

$currentAction = $Module->currentAction();

if ( !$group->isInternal() )
{
    if ( $currentAction == 'Remove' && $Module->hasActionParameter( 'RemoveIDList' ) )
    {
        $removeIDList = $Module->actionParameter( 'RemoveIDList' );
        $group->removeStatesByID( $removeIDList );
    }
    else if ( $currentAction == 'Edit' )
    {
        return $Module->redirectTo( "state/group_edit/$GroupIdentifier" );
    }
    else if ( $currentAction == 'Create' )
    {
        return $Module->redirectTo( "state/edit/$GroupIdentifier" );
    }
    else if ( $currentAction == 'UpdateOrder' && $Module->hasActionParameter( 'Order' ) )
    {
        $orderArray = $Module->actionParameter( 'Order' );
        asort( $orderArray );
        $stateIDList = array_keys( $orderArray );

        $group->reorderStates( $stateIDList );
    }
}

if ( $LanguageCode )
{
    $group->setCurrentLanguage( $LanguageCode );
}

$tpl->setVariable( 'group', $group );

$Result = array(
    'path' => array(
        array( 'url' => false, 'text' => ezi18n( 'kernel/state', 'State' ) ),
        array( 'url' => 'state/groups', 'text' => ezi18n( 'kernel/state', 'Groups' ) ),
        array( 'url' => false, 'text' => $group->attribute( 'current_translation' )->attribute( 'name' ) )
    ),
    'content' => $tpl->fetch( 'design:state/group.tpl' )
)
?>

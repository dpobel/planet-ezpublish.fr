<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$Module = $Params['Module'];
$roleID = $Params['RoleID'];

$role = eZRole::fetch( $roleID );
if ( $role )
{
    $newRole = $role->copy();
    return $Module->redirectToView( 'edit', array( $newRole->attribute( 'id' ) ) );
}
else
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

?>

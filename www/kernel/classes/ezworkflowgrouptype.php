<?php
/**
 * File containing the eZWorkflowGroupType class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

//!! eZKernel
//! The class eZWorkflowGroupType does
/*!

*/

class eZWorkflowGroupType extends eZWorkflowType
{
    function eZWorkflowGroupType( $typeString, $name )
    {
        $this->eZWorkflowType( "group", $typeString, ezpI18n::tr( 'kernel/workflow/group', "Group" ), $name );
    }

    static function registerGroupType( $typeString, $class_name )
    {
        eZWorkflowType::registerType( "group", $typeString, $class_name );
    }
}

?>

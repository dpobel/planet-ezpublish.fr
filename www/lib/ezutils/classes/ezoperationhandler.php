<?php
//
// Definition of eZOperationHandler class
//
// Created on: <06-Oct-2002 16:25:10 amos>
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

/*! \file
*/

/*!
  \class eZOperationHandler ezoperationhandler.php
  \brief The class eZOperationHandler does

*/

class eZOperationHandler
{
    /*!
     Constructor
    */
    function eZOperationHandler()
    {
    }

    static function moduleOperationInfo( $moduleName, $useTriggers = true )
    {
        if ( !isset( $GLOBALS['eZGlobalModuleOperationList'] ) )
        {
            $GLOBALS['eZGlobalModuleOperationList'] = array();
        }
        if ( isset( $GLOBALS['eZGlobalModuleOperationList'][$moduleName] ) )
        {
            return $GLOBALS['eZGlobalModuleOperationList'][$moduleName];
        }
        $moduleOperationInfo = new eZModuleOperationInfo( $moduleName, $useTriggers );
        $moduleOperationInfo->loadDefinition();
        return $GLOBALS['eZGlobalModuleOperationList'][$moduleName] = $moduleOperationInfo;
    }

    static function execute( $moduleName, $operationName, $operationParameters, $lastTriggerName = null, $useTriggers = true )
    {
        $moduleOperationInfo = eZOperationHandler::moduleOperationInfo( $moduleName, $useTriggers );
        if ( !$moduleOperationInfo->isValid() )
        {
            eZDebug::writeError( "Cannot execute operation '$operationName' in module '$moduleName', no valid data",
                                  'eZOperationHandler::execute' );
            return null;
        }
        return $moduleOperationInfo->execute( $operationName, $operationParameters, $lastTriggerName, $useTriggers );
    }

    /**
     * Checks if a trigger is defined in worklow.ini/[OperationSettings]/AvailableOperations
     *
     * @param string $name
     * @return boolean true if the operation is available, false otherwise
     */
    static public function operationIsAvailable( $name = false )
    {
        if ( $name === false )
        {
           return false;
        }

        // Check if read operations should be used
        $workflowINI = eZINI::instance( 'workflow.ini' );
        $operationList = $workflowINI->variableArray( 'OperationSettings', 'AvailableOperations' );
        $operationList = array_unique( array_merge( $operationList, $workflowINI->variable( 'OperationSettings', 'AvailableOperationList' ) ) );
        if ( in_array( $name, $operationList ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

?>

<?php
/**
 * File containing the eZWorkflowFunctionCollection class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/*!
  \class eZWorkflowFunctionCollection ezworkflowfunctioncollection.php
  \brief The class eZWorkflowFunctionCollection does

*/

class eZWorkflowFunctionCollection
{
    /*!
     Constructor
    */
    function eZWorkflowFunctionCollection()
    {
    }


    function fetchWorkflowStatuses()
    {
        return array( 'result' => eZWorkflow::statusNameMap() );
    }

    function fetchWorkflowTypeStatuses()
    {
        return array( 'result' => eZWorkflowType::statusNameMap() );
    }

}

?>

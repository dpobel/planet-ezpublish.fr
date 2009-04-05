<?php
/**
 * File containing the ezcWorkflowNodeFinally class.
 *
 * @package Workflow
 * @version 1.3.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Special type of start node that is activated when a workflow execution is
 * cancelled.
 *
 * Incoming nodes: 0
 * Outgoing nodes: 1
 *
 * @package Workflow
 * @version 1.3.1
 */
class ezcWorkflowNodeFinally extends ezcWorkflowNodeStart
{
}
?>

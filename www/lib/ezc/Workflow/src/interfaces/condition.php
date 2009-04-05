<?php
/**
 * File containing the ezcWorkflowCondition interface.
 *
 * @package Workflow
 * @version 1.3.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for workflow conditions.
 *
 * @package Workflow
 * @version 1.3.1
 */
interface ezcWorkflowCondition
{
    /**
     * Evaluates this condition.
     *
     * @param  mixed $value
     * @return boolean true when the condition holds, false otherwise.
     */
    public function evaluate( $value );

    /**
     * Returns a textual representation of this condition.
     *
     * @return string
     */
    public function __toString();
}
?>

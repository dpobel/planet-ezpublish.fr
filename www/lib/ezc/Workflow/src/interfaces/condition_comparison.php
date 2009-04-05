<?php
/**
 * File containing the ezcWorkflowConditionComparison class.
 *
 * @package Workflow
 * @version 1.3.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Abstract base class for comparison conditions.
 *
 * @package Workflow
 * @version 1.3.1
 */
abstract class ezcWorkflowConditionComparison implements ezcWorkflowCondition
{
    /**
     * @var mixed
     */
    protected $operator = '';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Constructs a new comparison condition.
     *
     * Implemenations will compare $value to the value provided to evaluate().
     *
     * @param  mixed  $value
     */
    public function __construct( $value = null )
    {
        $this->value = $value;
    }

    /**
     * Returns the value that this condition compares against.
     *
     * @return mixed
     * @ignore
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value that this condition compares against.
     *
     * @param mixed $value
     * @ignore
     */
    public function setValue( $value )
    {
        $this->value = $value;
    }

    /**
     * Returns the operator.
     *
     * @return string
     * @ignore
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Returns a textual representation of this condition.
     *
     * @return string
     * @ignore
     */
    public function __toString()
    {
        return $this->operator . ' ' . $this->value;
    }
}
?>

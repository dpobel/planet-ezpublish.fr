<?php
/**
 * File containing the ezcPhpGeneratorFlowException class
 *
 * @package PhpGenerator
 * @version 1.0.4
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Flow exceptions are thrown when control structures like if and while are closed out of order.
 *
 * @package PhpGenerator
 * @version 1.0.4
 */
class ezcPhpGeneratorFlowException extends ezcPhpGeneratorException
{
    /**
     * Constructs a new flow exception.
     *
     * $expectedFlow is the name of the control structure you expected the end of
     * and $calledFlow is the actual structure received.
     *
     * @param string $expectedFlow
     * @param string $calledFlow
     */
    function __construct( $expectedFlow, $calledFlow )
    {
        parent::__construct( "Expected end of '{$expectedFlow}' but got end of '{$calledFlow}'" );
    }
}

?>

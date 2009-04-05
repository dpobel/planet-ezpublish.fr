<?php
/**
 * File containing the ezcTemplateCustomFunction class
 *
 * @package Template
 * @version 1.3.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface for classes which provides custom functions to the template engine.
 * The classes must implement this interface and then return a
 * ezcTemplateCustomFunctionDefinition object from the method
 * getCustomFunctionDefinition().
 *
 * @package Template
 * @version 1.3.2
 */
interface ezcTemplateCustomFunction
{

    /**
     * Return a ezcTemplateCustomFunctionDefinition for the given function $name.
     *
     * @param string $name
     * @return ezcTemplateCustomFunctionDefinition
     */
    public static function getCustomFunctionDefinition( $name );
}

?>

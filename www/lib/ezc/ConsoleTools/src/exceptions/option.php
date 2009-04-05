<?php
/**
 * Base option exception for the ConsoleTools package.
 *
 * @package ConsoleTools
 * @version 1.5
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * General exception container for the ConsoleTools component referring to option handling.
 * This base container allows you to catch all exceptions which are related to 
 * errors produced by invalid user submitted options {@link ezcConsoleInput::process()}.
 *
 * @package ConsoleTools
 * @version 1.5
 */
abstract class ezcConsoleOptionException extends ezcConsoleException
{
}
?>

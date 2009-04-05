<?php
/**
 * File containing the ezcLogWrongSeverityException class.
 *
 * @package EventLog
 * @version 1.3
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcLogWrongSeverityException will be thrown when an {@link ezcLogWrongSeverity} or
 * a subclass encounters an exceptional state.
 *
 * This exception is a container, containing any kind of exception.
 *
 * @apichange Remove the wrapping of exceptions.
 * @package EventLog
 * @version 1.3
 */
class ezcLogWrongSeverityException extends ezcBaseException
{
    /**
     * Constructs a new ezcLogWrongSeverityException for severity $severity
     *
     * @param string $severity
     */
    public function __construct( $severity )
    {
        parent::__construct( "There is no severity named '{$severity}'." );
    }
}
?>

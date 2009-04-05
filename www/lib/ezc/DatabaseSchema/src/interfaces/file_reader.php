<?php
/**
 * File containing the ezcDbSchemaFileReader interface
 *
 * @package DatabaseSchema
 * @version 1.4.2
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for file schema readers
 *
 * @package DatabaseSchema
 * @version 1.4.2
 */
interface ezcDbSchemaFileReader extends ezcDbSchemaReader
{
    /**
     * Returns an ezcDbSchema with the definition from $file
     *
     * @param string $file
     * @return ezcDbSchema
     */
    public function loadFromFile( $file );
}
?>

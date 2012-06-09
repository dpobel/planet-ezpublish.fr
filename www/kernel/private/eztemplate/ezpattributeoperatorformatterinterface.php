<?php
/**
 * File containing interface definition for the 'attribute' template operator output formatter
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

interface ezpAttributeOperatorFormatterInterface
{
    /**
     * Formats header for the 'attribute' template operator output
     *
     * @param string $value
     * @param bool $showValues
     * @return string
     */
    public function header( $value, $showValues );

    /**
     * Formats single line for the 'attribute' template operator output
     *
     * @param string $key
     * @param mixed $item
     * @param bool $showValues
     * @param int $level
     * @return string
     */
    public function line( $key, $item, $showValues, $level );

    /**
     * Formats a scalar value like a string or an integer.
     *
     * @param mixed $value
     * @param return mixed
     */
    public function exportScalar( $value );
}

<?php
/**
 * File containing the ezpContentLocationCriteria class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package API
 */

/**
 * This class allows for configuration of a location based criteria
 * @package API
 */
class ezpContentLocationCriteria implements ezpContentCriteriaInterface
{
    /**
     * Sets a subtree criteria.
     * Content will only be accepted if it is part of the given subtree
     *
     * @param ezpLocation $subtree
     * @return ezpContentLocationCriteria
     */
    public function subtree( ezpContentLocation $subtree )
    {
        $this->subtree = $subtree;
        return $this;
    }

    /**
     * Temporary function that translates the criteria to something eZContentObjectTreeNode understands
     * @return array
     */
    public function translate()
    {
        return array( 'type' => 'location', 'value' => $this->subtree->node_id );
    }

    public function __toString()
    {
        return "part of subtree " . $this->subtree->node_id;
    }

    /**
     * @var ezpContentLocation
     */
    private $subtree;
}
?>

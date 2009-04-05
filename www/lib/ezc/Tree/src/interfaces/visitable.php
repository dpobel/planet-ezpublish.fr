<?php
/**
 * File containing the ezcTreeVisitable interface.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version 1.1.2
 * @filesource
 * @package Tree
 */

/**
 * Interface for visitable tree elements that can be visited
 * by ezcTreeVisitor implementations for processing using the
 * Visitor design pattern.
 *
 * All elements that will be part of the tree must
 * implement this interface.
 *
 * {@link http://en.wikipedia.org/wiki/Visitor_pattern Information on the Visitor pattern.}
 *
 * @package Tree
 * @version 1.1.2
 */
interface ezcTreeVisitable
{
    /**
     * Accepts the visitor.
     *
     * @param ezcTreeVisitor $visitor
     */
    public function accept( ezcTreeVisitor $visitor );
}
?>

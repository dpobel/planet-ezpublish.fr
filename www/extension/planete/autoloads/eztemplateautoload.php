<?php
/**
 * $Id$
 * $HeadURL$
 */

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array( 'script' => 'extension/planete/autoloads/planeteutils.php',
                                    'class' => 'eZPlaneteUtils',
                                    'operator_names' => array( 'clean_rewrite_xhtml', 'bookmarkize', 'entity_decode' ) );

?>

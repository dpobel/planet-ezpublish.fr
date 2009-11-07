<?php
/**
 * $Id$
 * $HeadURL$
 */

$Module = array( "name" => "Feed module" );

$ViewList['search'] = array( 'script'    => 'search.php',
                             'functions' => array( 'search' ),
                             'params'    => array( 'SearchText' ),
                             'unordered_params' => array( 'offset' => 'Offset' ) );

?>

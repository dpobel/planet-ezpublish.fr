#!/usr/bin/env php
<?php
require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(
    array(
        'description' => "Make sure the modified field of each ezcontentobject is not set to 0",
        'use-session' => false,
        'use-modules' => true,
        'use-extensions' => true
    )
);

$script->startup();
$script->initialize();

$db = eZDB::instance();

$rows = $db->arrayQuery( 'SELECT id FROM ezcontentobject WHERE modified = 0' );
foreach ( $rows as $row )
{
    $cli->output( 'Fixing content #' . $row['id'] );
    $rowVersion = $db->arrayQuery(
        "SELECT modified FROM ezcontentobject_version"
        . " WHERE contentobject_id={$row['id']} AND"
        . " status=" . eZContentObjectVersion::STATUS_PUBLISHED
    );
    $db->query(
        "UPDATE ezcontentobject SET modified={$rowVersion[0]['modified']}"
        . " WHERE id={$row['id']}"
    );
}


$script->shutdown();

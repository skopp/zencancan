<?php
require_once(dirname(__FILE__)."/../init.php");
require_once("DatabaseUpdate.class.php");

$databaseUpdate = new DatabaseUpdate(false,$sqlQuery);
$databaseUpdate->writeDefinition(dirname(__FILE__)."/zencancan.bin",dirname(__FILE__)."/zencancan.sql");


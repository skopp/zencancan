<?php
require_once(dirname(__FILE__)."/../init.php");

$databaseUpdate = new DatabaseUpdate(false,$sqlQuery);
$databaseUpdate->writeDefinition(DATABASE_FILE,dirname(__FILE__)."/zencancan.sql");


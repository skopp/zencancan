<?php
require_once(dirname(__FILE__)."/../init.php");
require_once("DatabaseUpdate.class.php");

$databaseUpdate = new DatabaseUpdate(file_get_contents(DATABASE_FILE),$sqlQuery);
$sqlCommand = $databaseUpdate->getDiff();

echo implode("\n",$sqlCommand);
exit($sqlCommand?1:0);

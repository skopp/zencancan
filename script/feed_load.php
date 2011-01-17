<?php
require_once( __DIR__ ."/../init.php");
require_once("FeedSQL.class.php");
require_once("FeedUpdater.class.php");

$feedSQL = new FeedSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,STATIC_PATH);

echo $feedUpdater->add($argv[1])?:$feedUpdater->getLastError() ."\n";


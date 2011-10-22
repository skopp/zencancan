#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");
require_once( __DIR__ ."/../init-feed.php");


$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);

$feedUpdater = new FeedUpdater($feedSQL,$feedFetchInfo,STATIC_PATH);
$feedUpdater->updateForever($abonnementSQL,LOG_FILE);



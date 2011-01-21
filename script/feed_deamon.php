#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");
require_once( __DIR__ ."/../init-feed.php");

require_once("FeedSQL.class.php");
require_once("FeedUpdater.class.php");
require_once("AbonnementSQL.class.php");



$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);

$feedUpdater = new FeedUpdater($feedSQL,$feedFetchInfo,STATIC_PATH);
$feedUpdater->updateForever($abonnementSQL,LOG_FILE);



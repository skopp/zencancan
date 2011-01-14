<?php
require_once( __DIR__ ."/../init.php");
require_once("FeedSQL.class.php");
require_once("FeedLoader.class.php");

$feedLoader = new FeedLoader();
$feedSQL = new FeedSQL($sqlQuery);

$url = $argv[1];

$feedInfo = $feedLoader->getInfo($url);

if (! $feedInfo) {
	echo $feedLoader->getLastError();
	exit;
}


$feedSQL->add($feedInfo);

print_r($feedInfo);
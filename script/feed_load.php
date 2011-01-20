<?php
require_once( __DIR__ ."/../init.php");
require_once( __DIR__ ."/../init-feed.php");

$result = $feedFetchInfo->getURL($argv[1]);
if (! $result){
	echo $feedFetchInfo->getLastError()."\n";
} else {
	print_r($result);
}

// $feedFetchInfo->getLastContent();
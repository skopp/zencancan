<?php
require_once( __DIR__ ."/../init.php");


$result = $objectInstancier->FeedFetchInfo->getURL($argv[1]);
if (! $result){
	echo $objectInstancier->FeedFetchInfo->getLastError()."\n";
	
} 

print_r($result);


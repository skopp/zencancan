<?php
require_once( __DIR__ ."/../init.php");

$entity = "&Atilde;";
echo htmlspecialchars(html_entity_decode($entity,ENT_QUOTES,"UTF-8"),ENT_QUOTES,"UTF-8");
exit;

$result = $objectInstancier->FeedFetchInfo->getURL($argv[1]);
if (! $result){
	echo $objectInstancier->FeedFetchInfo->getLastError()."\n";
	return;
} 


<?php
require_once( __DIR__ ."/../init.php");
require_once("FeedSQL.class.php");
require_once("FeedLoader.class.php");


const MIN_TIME_BEETWEEN_LOAD = 360;

$feedSQL = new FeedSQL($sqlQuery);
$feedLoader = new FeedLoader();

$id_f = 0;

while (true) { 
	$info = $feedSQL->getNext($id_f);
	if (! $info){
		$id_f=0;
		continue;
	}
	$id_f = $info['id_f'];
	
	$timeToSleep =  MIN_TIME_BEETWEEN_LOAD - (time() - strtotime($info['last_recup']));
	
	if ( $timeToSleep > 0){
		echo "Je m'endors pendant $timeToSleep s\n";
		sleep( $timeToSleep);
	}
	echo "Récup de {$info['url']}\n";
	$feedInfo = $feedLoader->get($info['url']);
	if (! $feedInfo ){
		$feedSQL->udpateLastRecup($info['url']);
	} else {
		$feedSQL->doUpdate($info['last_id'],$feedInfo);
	}

}
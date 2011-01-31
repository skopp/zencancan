<?php
require_once( __DIR__."/../init-web.php");
require_once( __DIR__ ."/../init-feed.php");

require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");
require_once("FeedUpdater.class.php");
require_once("ErrorSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,$feedFetchInfo,STATIC_PATH);
$errorSQL = new ErrorSQL($sqlQuery);

$id = $recuperateur->get('id');
$url = $recuperateur->get('url');

$sortie = function () use ($id) {
	header("Location: index.php?id=$id");
	exit;
};

$id_f = $feedUpdater->add($url);

if (! $id_f){
	$errorSQL->add($url,$feedUpdater->getLastError());
	$lastMessage->setLastMessage(LastMessage::ERROR,$feedUpdater->getLastError());
	$sortie();
} 
	
$abonnementSQL->add($id,$id_f);
	
$sortie();
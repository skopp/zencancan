<?php
require_once( __DIR__."/../init-web.php");
require_once( __DIR__ ."/../init-feed.php");


$recuperateur = new Recuperateur($_POST);
$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,$feedFetchInfo,STATIC_PATH);
$errorSQL = new ErrorSQL($sqlQuery);

$id = $recuperateur->get('id');
$url = $recuperateur->get('url');
$tag = $recuperateur->get('tag');

$sortie = function () use ($id,$tag) {
	header("Location: index.php?id=$id&tag=$tag");
	exit;
};

$id_f = $feedUpdater->add($url);

if (! $id_f){
	$errorSQL->add($url,$feedUpdater->getLastError());
	$lastMessage->setLastMessage(LastMessage::ERROR,$feedUpdater->getLastError());
	$sortie();
} 
	
$abonnementSQL->add($id,$id_f,$tag);
	
$sortie();
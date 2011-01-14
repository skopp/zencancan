<?php
require_once( dirname(__FILE__)."/../init.php");

require_once("FeedLoader.class.php");
require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$feedLoader = new FeedLoader();
$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);


$id = $recuperateur->get('id');
$url = $recuperateur->get('url');

$feedInfo = $feedLoader->get($url);

$sortie = function () use ($id) {
	header("Location: index.php?id=$id");
	exit;
};

if (! $feedInfo){
	$lastMessage->setLastMessage(LastMessage::ERROR,$feedLoader->getLastError());
	$sortie();
}

$abonnementSQL->add($id,$url);
$feedSQL->add($feedInfo);

	
$sortie();
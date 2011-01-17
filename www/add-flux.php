<?php
require_once( dirname(__FILE__)."/../init.php");

require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");
require_once("FeedUpdater.class.php");

$recuperateur = new Recuperateur($_POST);
$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,STATIC_PATH);

$id = $recuperateur->get('id');
$url = $recuperateur->get('url');

$sortie = function () use ($id) {
	header("Location: index.php?id=$id");
	exit;
};

$id_f = $feedUpdater->add($url);

if (! $id_f){
	$lastMessage->setLastMessage(LastMessage::ERROR,$feedUpdater->getLastError());
	$sortie();
} 
	
$abonnementSQL->add($id,$id_f);
	
$sortie();
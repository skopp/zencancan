<?php 
require_once( dirname(__FILE__)."/../init.php");
require_once("FeedUpdater.class.php");
require_once("AbonnementSQL.class.php");
require_once("FeedSQL.class.php");

$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,STATIC_PATH);

$recuperateur = new Recuperateur($_POST);
$id = $recuperateur->get('id');

$sortie = function () use ($id) {
	header("Location: index.php?id=$id");
	exit;
};

if (!$id){
	$sortie();
}

if (empty($_FILES['fichier_opml'])){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Fichier non présents");
	$sortie();
} 
	

if ($_FILES['fichier_opml']['error'] !=  UPLOAD_ERR_OK  ){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Erreur lors de l'import du fichier : ". $_FILES['fichier_opml']['error']);
	$sortie();
}

$xml = simplexml_load_file($_FILES['fichier_opml']['tmp_name']);
if ( ! $xml || ! $xml->body) {
	$lastMessage->setLastMessage(LastMessage::ERROR,"Ce n'est pas un fichier OPML");
	$sortie();
}

foreach($xml->body->outline as $feed){
	$id_f = $feedUpdater->addWithoutFetch($feed['xmlUrl']);
	$abonnementSQL->add($id,$id_f);
}

$sortie();
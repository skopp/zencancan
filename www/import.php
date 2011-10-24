<?php 
require_once( __DIR__."/../init-web.php");
require_once( __DIR__ ."/../init-feed.php");

require_once("FeedUpdater.class.php");
require_once("AbonnementSQL.class.php");
require_once("FeedSQL.class.php");

$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$feedUpdater = new FeedUpdater($feedSQL,$feedFetchInfo,STATIC_PATH);

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
	$objectInstancier->LastMessage->setLastError("Fichier non pr&eacute;sents");	
	$sortie();
} 
	

if ($_FILES['fichier_opml']['error'] !=  UPLOAD_ERR_OK  ){
	$objectInstancier->LastMessage->setLastError("Erreur lors de l'import du fichier : ". $_FILES['fichier_opml']['error']);		
	$sortie();
}

$xml = simplexml_load_file($_FILES['fichier_opml']['tmp_name']);
if ( ! $xml || ! $xml->body) {
	
	$objectInstancier->LastMessage->setLastError("Ce n'est pas un fichier OPML");
	$sortie();
}

foreach($xml->body->outline as $feed){
	$id_f = $feedUpdater->addWithoutFetch($feed['xmlUrl']);
	if ($id_f){
		$abonnementSQL->add($id,$id_f,"");
	}
}

$sortie();
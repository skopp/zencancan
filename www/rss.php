<?php

require_once( __DIR__."/../init.php");
require_once("AbonnementSQL.class.php");
require_once("RSSCreator.class.php");

$abonnementSQL = new AbonnementSQL($sqlQuery);
$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');
$tag = $recuperateur->get('tag');


$rssCreator = new RSSCreator("zenCancan - flux $id","Flux pour l'id $id",   $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] );

$allFlux = $abonnementSQL->getWithContent($id,0,$tag);

foreach($allFlux as $flux){
	$rssCreator->addItem($flux['title'] . ": " .$flux['item_title'],$flux['item_link'],$flux['last-modified'],$flux['item_content']);
}

echo $rssCreator->getRSS();
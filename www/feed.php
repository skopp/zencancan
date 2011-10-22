<?php
require_once( __DIR__."/../init-web.php");
require_once( __DIR__ ."/../init-feed.php");

$recuperateur = new Recuperateur($_GET);

$id = $recuperateur->get('id');
$id_f = $recuperateur->getInt('id_f');

$objectInstancier->FeedControler->detailAction($id,$id_f);


exit;


$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount(),$compte->isAdmin($authentification->getId()));

$pageHTML->addRSSURL("Votre flux zencancan","rss.php?id=$id");
if ($info['tag']){
	$pageHTML->addRSSURL("Votre flux zencancan - {$info['tag']}","rss.php?id=$id&tag={$info['tag']}");
}
$pageHTML->addRSSURL($info['title'],$info['url']);

$pageHTML->haut();
?>


<?php 
$pageHTML->bas();


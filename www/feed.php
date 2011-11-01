<?php
require_once( __DIR__."/../init-web.php");
require_once( __DIR__ ."/../init-feed.php");

$recuperateur = new Recuperateur($_GET);

$id = $recuperateur->get('id');
$id_f = $recuperateur->getInt('id_f');

$objectInstancier->FeedControler->detailAction($id,$id_f);

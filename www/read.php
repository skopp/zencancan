<?php
require_once( __DIR__."/../init-web.php");
$recuperateur = new Recuperateur($_GET);


$id = $recuperateur->get('id');
$id_f = $recuperateur->getInt('id_f');
$item = $recuperateur->get('item');


$objectInstancier->FeedControler->readAction($id,$id_f,$item);





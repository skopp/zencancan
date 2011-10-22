<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");
$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

$objectInstancier->ConnexionControler->loginAction($id);


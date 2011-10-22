<?php

require_once( __DIR__."/../init-web.php");



$recuperateur = new Recuperateur($_GET);
$id = $authentification->getId();


$objectInstancier->ParamControler->indexAction($id);

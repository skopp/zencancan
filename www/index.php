<?php

require_once( __DIR__."/../init-web.php");

$recuperateur = new Recuperateur($_GET);

$offset = $recuperateur->getInt('offset',0);
$tag = $recuperateur->get('tag');

$objectInstancier->FeedControler->listAction($id,$tag,$offset);



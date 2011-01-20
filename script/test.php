<?php
require_once( dirname(__FILE__)."/../init.php");
require_once( __DIR__ ."/../init-feed.php");

$urlLoader = new URLLoader();
$result = $urlLoader->getContent("http://fr.wikipedia.org/w/index.php?title=Sp%C3%A9cial:Modifications_r%C3%A9centes&feed=atom");

echo $result;

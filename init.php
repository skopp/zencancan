<?php

$debut = microtime(true);

require_once(  __DIR__  . "/LocalSettings.php");

set_include_path( __DIR__ . "/lib/" . PATH_SEPARATOR . __DIR__ . "/model" . PATH_SEPARATOR . __DIR__ . "/controler");

function __autoload($class_name) {	
	@ $result = include($class_name . '.class.php');
	if(!$result){
		throw new Exception("Impossible de trouver $class_name");
	}
	
}


$sqlQuery = new SQLQuery($database_name);
$sqlQuery->setDatabaseHost($database_host);
$sqlQuery->setCredential($database_login,$database_password);

setlocale(LC_ALL,"fr_FR.UTF-8");


define("DATABASE_FILE",dirname(__FILE__)."/script/zencancan.bin");
define("STATIC_PATH",dirname(__FILE__)."/static/");

define("LOG_FILE","/var/log/zencancan.log");



$objectInstancier = new ObjectInstancier();

$objectInstancier->site_index = $site_index;



$objectInstancier->debut = $debut;
$objectInstancier->template_path = __DIR__ . "/template/";
$objectInstancier->SQLQuery = $sqlQuery;
$objectInstancier->nbSigne = 7;
$objectInstancier->revision_number = 100;
$objectInstancier->timeout = 5;
$objectInstancier->staticPath = STATIC_PATH;



if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	$objectInstancier->GoogleSearch->setHTTPAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
}




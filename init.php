<?php

$debut = microtime(true);

set_include_path( __DIR__ . "/lib/" );

require_once(  __DIR__  . "/LocalSettings.php");

require_once("Recuperateur.class.php");
require_once("LastMessage.class.php");
require_once("SQLQuery.class.php");


$sqlQuery = new SQLQuery($database_name);
$sqlQuery->setDatabaseHost($database_host);
$sqlQuery->setCredential($database_login,$database_password);

setlocale(LC_ALL,"fr_FR.UTF-8");


define("DATABASE_FILE",dirname(__FILE__)."/script/zencancan.bin");
define("STATIC_PATH",dirname(__FILE__)."/static/");

define("LOG_FILE","/var/log/zencancan.log");

if (! defined("DOMAIN_NAME")){
	define("DOMAIN_NAME","zencancan.com");
}
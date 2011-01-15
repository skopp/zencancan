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

session_start();
$lastMessage = new LastMessage();


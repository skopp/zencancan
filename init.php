<?php

$debut = microtime(true);

set_include_path(  dirname(__FILE__) . "/lib/" );

require_once("Recuperateur.class.php");
require_once("LastMessage.class.php");

session_start();
$lastMessage = new LastMessage();


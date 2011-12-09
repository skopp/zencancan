<?php

require_once( __DIR__ ."/../init.php");

session_start();

$server_name = $_SERVER['SERVER_NAME'];
$name_account = strstr($server_name,"." . DOMAIN_NAME,true);


$objectInstancier->ZenCancanFrontControler->go();



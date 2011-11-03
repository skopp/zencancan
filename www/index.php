<?php
require_once( __DIR__."/../init-web.php");

$server_name = $_SERVER['SERVER_NAME'];
$name_account = strstr($server_name,"." . DOMAIN_NAME,true);

if ($name_account){
	$objectInstancier->defaultControler = "Feed";
	$objectInstancier->defaultAction = "List";
} else {
	$objectInstancier->defaultControler = "Aide";
	$objectInstancier->defaultAction = "Presentation";
}


$objectInstancier->ZenCancanFrontControler->go();



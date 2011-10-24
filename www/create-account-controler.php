<?php
require_once( __DIR__."/../init-web.php");

$recuperateur = new Recuperateur($_POST);

$id = $recuperateur->get('id');
$name = $recuperateur->get('name');
$password = $recuperateur->get('password');
$password2 = $recuperateur->get('password2');

$exit = function($message) use ($id){
	global $objectInstancier;
	$objectInstancier->LastMessage->setLastError($message);
	
	header("Location: create-account.php?id=$id");
	exit;
};

if (! $name){
	$exit("Il faut sp&eacute;cifier un nom de compte");
}

if ($password != $password2){
	$exit("Les mots de passe ne correspondent pas");
}

$result = $compte->create($id,$name,$password);
if (! $result){
	$exit($compte->getLastError());
}

$authentification->logout();
header("Location: http://$name.".DOMAIN_NAME);
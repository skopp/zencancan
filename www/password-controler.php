<?php 

require_once( __DIR__."/../init-web.php");
$recuperateur = new Recuperateur($_POST);

$oldpassword = $recuperateur->get('oldpassword');
$password = $recuperateur->get('password');
$password2 = $recuperateur->get('password2');

if ($password != $password2){
	$objectInstancier->LastMessage->setLastError("Les mots de passe ne correspondent pas");
	header("Location: password.php");
	exit;
}

$compte = new Compte($sqlQuery);

if ( ! $compte->verif($authentification->getNamedAccount(),$oldpassword)){
	$objectInstancier->LastMessage->setLastError("Votre ancien mot de passe est incorrecte");
	header("Location: password.php");
	exit;
}


$compte->setPassword($authentification->getId(),$password);


$objectInstancier->LastMessage->setLastMessage("Votre mot de passe a &eacute;t&eacute; modifi&eacute;");
header("Location: param.php");
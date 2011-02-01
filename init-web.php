<?php
require_once("init.php");
require_once("Compte.class.php");
require_once("Authentification.class.php");
require_once("PasswordGenerator.class.php");

session_start();
$lastMessage = new LastMessage();
$passwordGenerator = new PasswordGenerator();
$authentification = new Authentification($passwordGenerator);

if ($authentification->getNamedAccount() == 'www'){
	header("Location: http://".DOMAIN_NAME);
	exit;
}

$compte = new Compte($sqlQuery);

$id = $authentification->getId();

if ( ! $id){
	if ( ! in_array(basename($_SERVER['PHP_SELF']),array('login.php','login-controler.php') )) {
		header("Location: login.php");
		exit;
	}
}

if ($authentification->hasChangedId()){
	$accountName =  $compte->getAccountName($id);
	if ($accountName){
		$authentification->logout();
		header("Location: http://$accountName.".DOMAIN_NAME);
		exit;
	}
	
}
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


if ( isset($_COOKIE['remember_zencancan'])){
	if (! $id){
		$id = $compte->verifRemember($authentification->getNamedAccount(),$_COOKIE['remember_zencancan'] );
		if ($id){
			$authentification->setId($id);
		}
	} elseif ( ! $authentification->getNamedAccount() ) {
		$username = $compte->verifWithoutName($_COOKIE['remember_zencancan']);
		if ($username){
			$id = $compte->verifRemember($username,$_COOKIE['remember_zencancan'] );
			$verif_id = md5(mt_rand(0,mt_getrandmax()));
			apc_store("verif_$id",$verif_id,60);
			header("Location: http://$username.".DOMAIN_NAME."/auto-login.php?id=$id&verif=$verif_id&remember=true");
			exit;
		} else {
			setcookie("remember_zencancan","");
		}
	}
}

if ( ! $id){
	if ( ! in_array(basename($_SERVER['PHP_SELF']),array('login.php','login-controler.php','auto-login.php') )) {
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
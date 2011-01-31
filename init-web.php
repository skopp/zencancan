<?php
require_once("init.php");
require_once("Compte.class.php");
require_once("Authentification.class.php");
require_once("PasswordGenerator.class.php");

session_start();
$lastMessage = new LastMessage();
$passwordGenerator = new PasswordGenerator();
$authentification = new Authentification($passwordGenerator);


$compte = new Compte($sqlQuery);

$id = $authentification->getId();

if ( ! $id){
	if ( ! in_array(basename($_SERVER['PHP_SELF']),array('login.php','login-controler.php') )) {
		header("Location: login.php");
		exit;
	}
	
}

<?php
require_once( __DIR__."/../init-web.php");


$recuperateur = new Recuperateur($_POST);

$password = $recuperateur->get('password');
$username = $authentification->getNamedAccount();
$id = $compte->verif($username,$password);
if (! $id ){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Le mot de passe est incorrect");
	header("Location: login.php");		
	exit;
}


$authentification->setId($id);
header("Location: index.php?id=$id");

<?php
require_once( __DIR__."/../init-web.php");


$recuperateur = new Recuperateur($_POST);

$password = $recuperateur->get('password');
$login = $recuperateur->get('login');
$remember = $recuperateur->get('remember');

$username = $authentification->getNamedAccount();

if (! $username){
	$username = $login;
}

$id = $compte->verif($username,$password);

if (! $id ){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Le mot de passe est incorrect");
	header("Location: login.php");		
	exit;
}

if ($remember){
	$verif_id = $compte->getRemember($id);;
	setcookie("remember_zencancan",$verif_id,time()+3600*24*365);
}

if ($authentification->getNamedAccount()) {
	$authentification->setId($id);
	header("Location: index.php?id=$id");
} else {
	$verif_id = md5(mt_rand(0,mt_getrandmax()));
	apc_store("verif_$id",$verif_id,60);
	header("Location: http://$username.".DOMAIN_NAME."/auto-login.php?id=$id&verif=$verif_id");
}


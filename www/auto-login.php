<?php
require_once( __DIR__."/../init-web.php");


$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');
$verif = $recuperateur->get('verif');
$remember = $recuperateur->get('remember');


if ($verif && $id && (apc_fetch("verif_$id")== $verif)){
	
	$compte = new Compte($sqlQuery);
	if ($remember){
		$remember = $compte->getRemember($id);
		setcookie("remember_zencancan",$remember,time()+3600*24*365);
	}
	
	$authentification->setId($id);
	header("Location: index.php?id=$id");
} else {
	header("Location: login.php");
}
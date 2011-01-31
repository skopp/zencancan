<?php 
require_once( dirname(__FILE__)."/../init.php");

require_once("AbonnementSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$id = $recuperateur->get('id');
$code = $recuperateur->get('code');

if ($code != $id){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Veuilles saisir l'identifiant du compte ($id)");
	header("Location: param.php?id=$id");
	exit;
}


$abonnementSQL = new AbonnementSQL($sqlQuery);
$abonnementSQL->delCompte($id);
	
header("Location:index.php");

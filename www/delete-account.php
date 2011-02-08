<?php 
require_once( __DIR__."/../init-web.php");

require_once("AbonnementSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$id = $recuperateur->get('id');
$code = $recuperateur->get('code');

if ($code != $id){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Veuillez saisir l'identifiant du compte ($id)");
	header("Location: param.php?id=$id");
	exit;
}


$abonnementSQL = new AbonnementSQL($sqlQuery);
$abonnementSQL->delCompte($id);
	
if ($authentification->getNamedAccount()){
	$compte->delete($authentification->getNamedAccount());
}
$authentification->logout();
header("Location: http://".DOMAIN_NAME);

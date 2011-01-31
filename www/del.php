<?php 
require_once( __DIR__."/../init-web.php");

require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$feedSQL = new FeedSQL($sqlQuery);
$abonnementSQL = new AbonnementSQL($sqlQuery);


$id = $recuperateur->get('id');
$id_f = $recuperateur->get('id_f');

$abonnementSQL->del($id,$id_f);
//$feedSQL->add($feedInfo);

	
header("Location:index.php?id=$id");
exit();
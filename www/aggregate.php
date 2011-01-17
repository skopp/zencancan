<?php 
require_once( dirname(__FILE__)."/../init.php");

require_once("AbonnementSQL.class.php");

$recuperateur = new Recuperateur($_POST);
$abonnementSQL = new AbonnementSQL($sqlQuery);


$id = $recuperateur->get('id');
$id_f = $recuperateur->get('id_f');
$tag = $recuperateur->get('tag');

$abonnementSQL->addTag($id,$id_f,$tag);

	
header("Location:feed.php?id=$id&id_f=$id_f");
exit();
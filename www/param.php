<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PageHTML.class.php");
require_once("util.php");

$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

if (!$id){
	header("Location: index.php");
	exit;
}



$pageHTML = new PageHTML($id,$debut);

$pageHTML->haut();
?>
<p class='petit'>
<a href='index.php?id=<?php hecho($id)?>'>« Revenir à la liste des sites</a>
</p>

<h2>Mon compte</h2>

<h3>Importer des flux</h3>
<form action='import.php' enctype='multipart/form-data' method='post'>
	<input type='hidden' name='id' value='<?php hecho($id) ?>' />
	Fichier OPML : <input type='file' name='fichier_opml' />
	<input type='submit' name='Envoyer' />
</form>

<h3>Exporter mes flux</h3>

<?php 

$pageHTML->bas();

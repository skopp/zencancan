<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");
require_once("util.php");

$recuperateur = new Recuperateur($_GET);
$id = $authentification->getId();

if (!$authentification->getId()){
	header("Location: index.php");
	exit;
}

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());

$pageHTML->haut();
?>


<div class="box">
	<div class="haut">
<h2>Mon compte</h2>
</div>
	<div class="cont">

<p class='petit'>
<a href='index.php?id=<?php hecho($id)?>'>« Revenir à la liste des sites</a>
</p>

<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>

<?php if ( ! $authentification->getNamedAccount() ):?>
<br/>
<p>

<a href='create-account.php?id=<?php echo $id ?>'>Créer un compte nommé </a>
(exemple : eric.<?php echo DOMAIN_NAME ?>)
</p>

<?php else:?>
<br/>
<p>
<a href='password.php'>Modifier mon mot de passe</a>
</p>
<?php endif;?>

<h2>Import/export</h2>

<h3>Importer des flux</h3>
<form action='import.php' enctype='multipart/form-data' method='post'>
	<input type='hidden' name='id' value='<?php hecho($id) ?>' />
	Fichier OPML : <input type='file' name='fichier_opml' />
	<input type='submit' name='Envoyer' />
</form>

<h3>Exporter mes flux</h3>

<a href='export.php?id=<?php hecho($id)?>'>zencancan-<?php hecho($id) ?>.opml</a>

<h2>Supression</h2>

Détruire ce compte définitivement. 

<form action='delete-account.php' method='post'>
<input type='hidden' name='id' value='<?php echo $id?>' />
Veuillez saisir l'identifiant du compte : <input name='code' value=''/>
<input type='submit' value='Détruire'/>
<br/>
<b>Cette opération n'est pas réversible</b>

</form>
</div>
</div>
<?php 

$pageHTML->bas();

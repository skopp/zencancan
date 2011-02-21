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

<div id="contenu">


<p class="breadcrumbs">
<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir &agrave; la liste des sites</a>
</p>

<div class="box">
	<div class="haut"><h2>Mon compte</h2></div>
	<div class="cont">

	voici mon compte en texte normal et ici <a href="#">un lien pas</a> ici par la.
	
	<?php if ($lastMessage->getLastMessage()) : ?>
		<p><?php echo $lastMessage->getLastMessage(); ?></p>
	<?php endif;?>
	
	</div>
	<div class="bas"></div>
</div>

<?php if ( ! $authentification->getNamedAccount() ):?>
<div class="box">
	<div class="haut"><h2>Cr&eacute;er un compte</h2></div>
	<div class="cont align_center">
	<p>
	<a href="create-account.php?id=<?php echo $id ?>" class="a_btn">Cr&eacute;er un compte nomm&eacute; </a>
	</p>
	
	<p class="discret">Exemple : eric.<?php echo DOMAIN_NAME ?></p>
	
	</div>
	<div class="bas"></div>
</div>
<?php else:?>
<div class="box">
	<div class="haut"><h2>Modifier un compte</h2></div>
	<div class="cont">
		<p>
		<a href="password.php">Modifier mon mot de passe</a>
		</p>
	</div>
	<div class="bas"></div>
</div>
<?php endif;?>


<div class="box">
	<div class="haut"><h2>Mes donn&eacute;es</h2></div>
	<div class="cont">

	<p class="box_info">
	R&eacute;cuperer mes donn&eacute;es : <a href='export.php?id=<?php hecho($id)?>'>zencancan-<?php hecho($id) ?>.opml</a>
	</p>


	<form action='import.php' enctype='multipart/form-data' method='post'>
		
		<input type='hidden' name='id' value='<?php hecho($id) ?>' />
		<label for='fichier_opml' >Importer des flux (OPML)</label>
		<input type='file' name='fichier_opml' />
		<input type='submit' name='Envoyer' class='a_btn' />
	</form>
	</div>
	<div class="bas"></div>
</div>


<div class="box">
	<div class="haut"><h2>Supprimer mon compte</h2></div>
	<div class="cont">


	<p class="box_info">D&eacute;truire ce compte d&eacute;finitivement.</p>

<form action='delete-account.php' method='post'>
<input type='hidden' name='id' value='<?php echo $id?>' />
Veuillez saisir l'identifiant du compte : <input name='code' value=''/>
<input type='submit' value='D&eacute;truire' class='a_btn'/>

<p class="box_alert">Cette op&eacute;ration n'est pas r&eacute;versible</p>

</form>
	</div>
	<div class="bas"></div>
</div>


</div><!-- fin contenu -->
<?php 

$pageHTML->bas();

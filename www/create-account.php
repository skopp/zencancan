<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

if (!$id){
	$id = $authentification->getId();
}

$pageHTML = new PageHTML($id,$debut);

$pageHTML->haut();
?>

<div class="box">
			<div class="haut">
<h2>Création d'un compte</h2>
	</div>
<div class="cont">
	
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='create-account-controler.php' method='post'>
	<input type='hidden' name='id' value='<?php echo $id?>' />
	<label for="name">Nom du compte</label>
	<input name='name'/>.<?php echo DOMAIN_NAME ?>
	<hr/>
	<label for="password">Mot de passe</label>
	<input type='password' name='password'/>
	<hr/>
	<label for="password2">Mot de passe (vérification)</label>
	<input type='password' name='password2'/><br/>
	<hr/>
	<input type='submit' class='submit' value='Créer le compte'/>
</form>
</div>
</div>
<?php 
$pageHTML->bas();
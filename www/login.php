<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");



$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

$pageHTML = new PageHTML(false,$debut,false);

$pageHTML->haut();
?>

<?php if ($authentification->getNamedAccount()) : ?>
<h2>Connexion au compte <?php echo $authentification->getFullAccountName(); ?></h2>
<?php else : ?>
<h2>Connexion</h2>
<?php endif;?>

<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='login-controler.php' method='post'>
	<?php if (! $authentification->getNamedAccount()) : ?>
	Identifiant : <input type='text' name='login'/>.<?php echo DOMAIN_NAME ?><br/>
	<?php endif; ?>
	Mot de passe : <input type='password' name='password'/><br/>
	
	 <input type='checkbox' name='remember'/> Rester connecté<br/>
	<input type='submit' value='Connexion'/>
</form>

<p>
<a href='http://<?php echo DOMAIN_NAME?>'>Utiliser un compte anonyme</a>
<a href='http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>'>Créer un compte</a></p>
<?php 
$pageHTML->bas();
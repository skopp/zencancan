<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");



$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

$pageHTML = new PageHTML(false,$debut,$authentification->getNamedAccount());

$pageHTML->haut();
?>

<div class="box">
			<div class="haut">
<?php if ($authentification->getNamedAccount()) : ?>
<h2>Connexion au compte <?php echo $authentification->getFullAccountName(); ?></h2>
<?php else : ?>
<h2>Connexion</h2>
<?php endif;?>
</div>
<div class="cont">
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='login-controler.php' method='post'>
	<?php if (! $authentification->getNamedAccount()) : ?>
		<label for="login">Identifiant</label>
	 	<input type='text' name='login'/>.<?php echo DOMAIN_NAME ?>
	 	<hr/>
	<?php endif; ?>
		<label for="password">Mot de passe</label>
		<input type='password' name='password'/>
		
		 <hr/>
		<input type='submit' class="submit" value='Connexion'/>
		<input type='checkbox' name='remember'/>
		Rester connect&eacute;
		<br/>
		
	
</form>

<p>
<a href='http://<?php echo DOMAIN_NAME?>'>Utiliser un compte anonyme</a>
<a href='http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>'>Cr&eacute;er un compte</a></p>
					
	</div>
	<div class="bas"></div>				
</div>
<?php 
$pageHTML->bas();
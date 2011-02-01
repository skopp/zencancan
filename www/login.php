<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

if (! $authentification->getNamedAccount()){
	header("Location: index.php");
	exit;
}

$recuperateur = new Recuperateur($_GET);

$pageHTML = new PageHTML(false,$debut,false);

$pageHTML->haut();
?>

<h2>Connexion au compte <?php echo $authentification->getFullAccountName(); ?></h2>
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='login-controler.php' method='post'>
	
	Mot de passe : <input type='password' name='password'/><br/>
	<input type='submit' value='Connexion'/>
</form>

<a href='http://<?php echo DOMAIN_NAME?>'>Utiliser un compte anonyme</a>
<?php 
$pageHTML->bas();
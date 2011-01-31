<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$recuperateur = new Recuperateur($_GET);

$pageHTML = new PageHTML(false,$debut,false);

$pageHTML->haut();
?>

<h2>Connexion à votre compte</h2>
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='login-controler.php' method='post'>
	
	Mot de passe : <input type='password' name='password'/><br/>
	<input type='submit' value='Connexion'/>
</form>

<?php 
$pageHTML->bas();
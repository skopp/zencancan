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

<h2>Création d'un compte</h2>
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='create-account-controler.php' method='post'>
	<input type='hidden' name='id' value='<?php echo $id?>' />
	Nom du compte : <input name='name'/>.<?php echo DOMAIN_NAME ?><br/>
	Mot de passe : <input type='password' name='password'/><br/>
	Mot de passe (vérification): <input type='password' name='password2'/><br/>
	<input type='submit' value='Créer le compte'/>
</form>

<?php 
$pageHTML->bas();
<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");



$recuperateur = new Recuperateur($_GET);
$id = $recuperateur->get('id');

$pageHTML = new PageHTML(false,$debut,$authentification->getNamedAccount());

$pageHTML->haut();
?>
<div id="contenu">

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
		<label for="id_login">Identifiant</label>
	 	<input type='text' name='login' id="id_login" />.<?php echo DOMAIN_NAME ?>
	 	<hr/>
	<?php endif; ?>
		<label for="id_password">Mot de passe</label>
		<input type='password' id="id_password" name='password'/>
		<hr/>	

		<p class="align_right">
		<label for="id_remember">Rester connect&eacute;</label><input type="checkbox" name="remember" id="id_remember" />
		&nbsp;&nbsp;
		<input type="submit" class="submit" value="Connexion" />
		</p>
		

</form>
	</div>
	<div class="bas"></div>				
</div>

</div><!-- fin contenu -->

<div id="colonne">


<div class="box">
	<div class="haut"><h2>Pas encore inscrit ?</h2></div>
	<div class="cont align_center">
<br/>
<p>
<a class="a_btn" href="http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>">Cr&eacute;er un compte gratuitement</a>
</p>

<br/>

<hr/>
<br/>
<p>
<a href="http://<?php echo DOMAIN_NAME?>">Utiliser un compte anonyme</a>
</p>
	<br/>				
	</div>
	<div class="bas"></div>				
</div>


</div><!-- fin colonne -->
<?php 
$pageHTML->bas();
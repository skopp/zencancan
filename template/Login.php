<?php $this->render("Menu");?>


<div id="contenu">

<?php if ($namedAccount) : ?>
<h1>Connexion au compte <?php echo $this->Authentification->getFullAccountName(); ?></h1>
<a href='<?php echo $this->Path->getPathWithUsername("","/Connexion/login");?>'>changer de compte</a>
<?php else : ?>
<h1>Connexion</h1>
<?php endif;?>


<div class="box">
<?php $this->LastMessage->display()?>
<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Connexion/doLogin' />
	<?php if (! $namedAccount) : ?>
	
	<p><label for="id_login">Identifiant</label></p>
	<p><input type='text' name='login' id="id_login" value='<?php echo $this->LastMessage->getLastInput("login")?>'/>.<?php echo DOMAIN_NAME ?></p>
	<?php endif; ?>

	<p><label for="id_password">Mot de passe</label></p>
	<p><input type='password' id="id_password" name='password'/></p>

	<p><input type="checkbox" name="remember" id="id_remember" /><label for="id_remember">Rester connect&eacute;</label></p>

	<input type="submit" class="submit" value="Connexion" />

</form>
	
</div>


</div>
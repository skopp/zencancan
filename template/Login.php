
	<?php $this->render("Menu");?>


<div id="contenu">

<div class="box">
	<div class="haut">
<?php if ($namedAccount) : ?>
<h2>Connexion au compte <?php echo $this->Authentification->getFullAccountName(); ?></h2>
<a href='<?php echo $this->Path->getPathWithUsername("","/Connexion/login");?>'>changer de compte</a>
<?php else : ?>
<h2>Connexion</h2>
<?php endif;?>
</div>
<div class="cont">
<?php $this->LastMessage->display()?>
<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Connexion/doLogin' />
	<?php if (! $namedAccount) : ?>
		<label for="id_login">Identifiant</label>
	 	<input type='text' name='login' id="id_login" value='<?php echo $this->LastMessage->getLastInput("login")?>'/>.<?php echo DOMAIN_NAME ?>
	 	<hr/>
	<?php endif; ?>
		<label for="id_password">Mot de passe</label>
		<input type='password' id="id_password" name='password'/>
		<hr/>	

		<p class="align_left">
		<label for="id_remember">Rester connect&eacute;</label><input type="checkbox" name="remember" id="id_remember" />
		&nbsp;&nbsp;
		<input type="submit" class="submit" value="Connexion" />
		</p>
</form>
	</div>
	<div class="bas"></div>				
</div>


</div>
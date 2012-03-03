<?php $this->render("Menu");?>


<div id="contenu">


<h1>Connexion</h1>


<div class="box">
<?php $this->LastMessage->display()?>
<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Connexion/doLogin' />
	<p><label for="id_login">Identifiant</label></p>
	<p><input type='text' name='login' id="id_login" value='<?php echo $this->LastMessage->getLastInput("login")?>'/></p>
	<p><label for="id_password">Mot de passe</label></p>
	<p><input type='password' id="id_password" name='password'/></p>
	<p><input type="checkbox" name="remember" id="id_remember" /><label for="id_remember">Rester connect&eacute;</label></p>
	<input type="submit" class="submit" value="Connexion" />
</form>
</div>



<div class="box">
	<div class="haut"><h2>Pas encore de compte ? </h2></div>
	<div class="cont">
		<a href='<?php $this->Path->path('/Account/create');?>'>Créer un compte</a> gratuitement et simplement.
	</div>
</div>


</div>
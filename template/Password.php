<?php $this->render("Menu");?>

<a href='<?php $this->Path->path("/Param/index")?>'>&laquo; Revenir aux param&egrave;tres du compte </a>


<div class="box">
			<div class="haut">
<h2>Modifier de votre mot de passe</h2>
	</div>
<div class="cont">

<?php $this->LastMessage->display(); ?>
<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/doPassword' />
	<label for="oldpassword">Votre ancien mot de passe</label>
	<input type='password' name='oldpassword'/>
	<hr/>
	<label for="password">Nouveau mot de passe</label>
	<input type='password' name='password'/>
	<hr/>
	<label for="password2">Nouveau mot de passe (v&eacute;rification)</label>
	<input type='password' name='password2'/><br/>
	<hr/>
	<input type='submit' class='submit' value='Modifier'/>
</form>
</div>
</div>
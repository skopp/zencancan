<?php $this->render("Menu");?>
<div id="contenu">

<h1>Modifier de votre mot de passe</h1>

<div class="box">



<?php $this->LastMessage->display(); ?>
<form class='ff' action='<?php $this->Path->path() ?>' method='post'>

	<a href='<?php $this->Path->path("/Param/index")?>'>&laquo; Revenir aux param&egrave;tres du compte </a>

	<hr/>
	
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/doPassword' />
	
	<p><label for="oldpassword">Votre ancien mot de passe</label></p>
	<p><input type='password' name='oldpassword'/></p>
	
	<p><label for="password">Nouveau mot de passe</label></p>
	<p><input type='password' name='password'/></p>
	
	<p><label for="password2">Nouveau mot de passe (v&eacute;rification)</label></p>
	<p><input type='password' name='password2'/></p>
	
	
	<input type='submit' class='submit' value='Modifier'/>
</form>

</div><!-- fin box -->

</div><!-- fin contenu -->

	<?php $this->render("Menu");?>

<div id="contenu">

<div class="box">
	<div class="haut"><h2>Cr&eacute;ation d'un compte</h2></div>
	<div class="cont">
	
	<?php $this->LastMessage->display(); ?>
		<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
		<?php $this->Connexion->displayTokenField(); ?>
		<input type='hidden' name='path_info' value='/Account/doCreate' />		
		<label for="name">Nom du compte</label>
		<input name='name' value='<?php echo $this->LastMessage->getLastInput('name')?>'/>.<?php echo DOMAIN_NAME ?>
		<hr/>
		<label for="password">Mot de passe</label>
		<input type='password' name='password'/>
		<hr/>
		<label for="password2">Mot de passe (v&eacute;rification)</label>
		<input type='password' name='password2'/><br/>
		<hr/>
		<p class="align_right">
		<input type='submit' class='submit' value='Cr&eacute;er le compte'/>
		</p>
	</form>
	</div>
	<div class="bas"></div>
</div>

</div><!-- fin contenu -->
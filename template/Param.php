<?php $this->render("Menu");?>
<div id="contenu">


<?php $this->LastMessage->display(); ?>

<h1>Paramètres</h1>

<div class="box">
		<a class='a_btn' href="<?php $this->Path->path("/Param/password")?>">Modifier mon mot de passe</a>
</div>


<div class="box">
	<h2>Mes donn&eacute;es</h2>


	<p>R&eacute;cuperer mes donn&eacute;es : <a href='<?php $this->Path->path("/Param/export")?>'>zencancan.opml</a>
</p>
	
<form class='ff' action='<?php $this->Path->path() ?>' method='post' enctype='multipart/form-data'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/import' />
		
		<label for='fichier_opml' >Importer des flux (OPML)</label>
		<input type='file' name='fichier_opml' id='fichier_opml'/>
		<input type='submit' name='Envoyer' class='a_btn' />
	</form>

</div>


<div class="box">
	<div class="haut"><h2>Supprimer mon compte</h2></div>
	<div class="cont">


	
<form class='ff' action='<?php $this->Path->path() ?>' method='post' >
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/delete' />

<p class="box_info">D&eacute;truire ce compte d&eacute;finitivement. (Cette op&eacute;ration n'est pas r&eacute;versible)</p>

<input type='hidden' name='id' value='<?php echo $id?>' />
Veuillez saisir l'identifiant du compte : <input name='code' value=''/>
<br/>
Veuillez saisir votre mot de passe : <input name='password' type='password' value=''/>

<input type='submit' value='D&eacute;truire' class='a_btn'/>


</form>
	</div>
	<div class="bas"></div>
</div>


</div><!-- fin contenu -->
				
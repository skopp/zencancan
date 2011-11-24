<?php $this->render("Menu");?>
<div id="contenu">


<?php $this->LastMessage->display(); ?>

<h1>Param&egrave;tres</h1>

<div class="box">
	<a class='a_btn' href="<?php $this->Path->path("/Param/password")?>">Modifier mon mot de passe</a>
</div>


<div class="box">
	<form class='ff' action='<?php $this->Path->path() ?>' method='post' enctype='multipart/form-data'>
	<h2>Mes donn&eacute;es</h2>
	<hr/>

	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/import' />
		
		<p><label for='fichier_opml' >Importer des flux (OPML)</label></p>
		<p><input class='input_file' type='file' name='fichier_opml' id='fichier_opml'/></p>

		

		<input type='submit' name='Envoyer' class='submit' />
		
		<hr/>
		
		<p>
	R&eacute;cuperer mes donn&eacute;es : <a href='<?php $this->Path->path("/Param/export")?>'>zencancan.opml</a>
		</p>
		
	</form>

</div>






<div class="box">

	<form class='ff' action='<?php $this->Path->path() ?>' method='post' >
	<h2>Supprimer mon compte</h2>
	<hr/>

	<div class="box_alert">D&eacute;truire ce compte d&eacute;finitivement. (Cette op&eacute;ration n'est pas r&eacute;versible)</div>
	
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/delete' />
	<input type='hidden' name='id' value='<?php echo $id?>' />
	
	<p><label for="lab_1">Veuillez saisir l'identifiant du compte</label></p>
	<p><input type='text' name='code' id='lab_1' value=''/></p>
	
	<p><label for="lab_2">Veuillez saisir votre mot de passe</label></p>
	<p><input type='text' name='password' id='lab_2' type='password' value=''/></p>
		
	<input type='submit' value='D&eacute;truire' class='submit'/>

</form>

</div>


</div><!-- fin contenu -->
				
<?php $this->render("Menu");?>
<div id="contenu">


<p class="breadcrumbs">
<a class="a_btn_nav" href="<?php $this->Path->path()?>">&laquo; Revenir &agrave; la liste des sites</a>
</p>



		<?php $this->LastMessage->display(); ?>

<div class="box">
	<div class="haut"><h2>Modifier un compte</h2></div>
	<div class="cont">
		<div class="box_deco">
		<a class='a_btn' href="<?php $this->Path->path("/Param/password")?>">Modifier mon mot de passe</a>
		</div>
	</div>
	<div class="bas"></div>
</div>


<div class="box">
	<div class="haut"><h2>Mes donn&eacute;es</h2></div>
	<div class="cont">




	<div class="box_deco">
	R&eacute;cuperer mes donn&eacute;es : <a href='<?php $this->Path->path("/Param/export")?>'>zencancan.opml</a>
	</div>
	
<form class='ff' action='<?php $this->Path->path() ?>' method='post' enctype='multipart/form-data'>
	<?php $this->Connexion->displayTokenField(); ?>
	<input type='hidden' name='path_info' value='/Param/import' />
		
		<label for='fichier_opml' >Importer des flux (OPML)</label>
		<input type='file' name='fichier_opml' />
		<input type='submit' name='Envoyer' class='a_btn' />
	</form>
	</div>
	<div class="bas"></div>
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
				
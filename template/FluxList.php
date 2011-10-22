

<div id="contenu">

<?php if ($this->LastMessage->getLastMessage()) : ?>
<div class="<?php echo $this->LastMessage->getLastMessageType()==LastMessage::ERROR?'box_error':'box_confirm'?>"><p>
<?php echo $this->LastMessage->getLastMessage(); ?>
</p></div>
<?php endif;?>
	

<form action='add-flux.php' method='post'>
<input type='hidden' name='id'  value='<?php hecho($id) ?>' />
<input type='hidden' name='tag'  value='<?php hecho($tag) ?>' />

Ajouter un site<?php echo $tag?" dans la cat&eacute;gorie $tag":""?>: <br/>

<input type='text' size='50' name='url' />

<input type='submit' value='Suivre' class="a_btn" />
<p class='petit'>Exemple: L'Equipe, Le Monde, Morandini, ...</p>
</form>

<?php if ($allFlux) : ?>
<div class="box">
	<div class="haut">
		<h2>Derni&egrave;res mises &agrave; jour<?php echo $tag?" dans la cat&eacute;gorie $tag":""?></h2>
	</div>
	<div class="cont">
	
	<?php if ($tag) : ?>
		<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir &agrave; la liste des sites</a>
	<?php endif;?>
	<?php 
		$paginator->displayNext("&laquo; Sites mis &agrave; jour plus r&eacute;cemment"); 
		$this->FeedHTML->display($allFlux,$id,$tag);
		$paginator->displayPrevious("Sites mis &agrave; jour avant &raquo;");
	?>
</div>
			<div class="bas"></div>				
		</div>
<?php else: ?>
<div class="box">
	<div class="haut">
	<h2>Suivi des sites</h2>
	</div>
	<div class="cont">
	
	<div class="box_info">
	<p>Vous ne suivez actuellement aucun site.</p>
	<p>Pour suivre un site, inscrivez son nom dans le formulaire ci-dessus.</p>
	</div>
	
	
</div>
<div class="bas"></div>				
</div>

<?php endif;?>


</div>

<div id="colonne">
<?php if (! $namedAccount ) : ?>
<div class="box">
	<div class="haut"><h2>Compte anonyme</h2></div>
	<div class="cont">
	
	<p>Vous &ecirc;tes actuellement sur un compte anonyme.</p>
	<p>Adresse de cette page : <a href='http://<?php echo DOMAIN_NAME?>?<?php echo $id?>'>http://<?php echo DOMAIN_NAME?>?id=<?php echo $id?></a></p>
	
	<p class="align_center">
		<a class="a_btn" href="http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>">Cr&eacute;er un compte gratuitement</a>
	</p>
	
	
</div>
<div class="bas"></div>				
</div>
<?php endif;?>

</div><!-- fin contenu -->

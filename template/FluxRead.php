<div id="colonne" class="colonne_max">

<div class="box">
	
	<div class="info_blog">
	
	<h2><img src="<?php $this->Path->echoRessourcePath("/static/favicon/{$abonnementInfo['favicon']}") ?>" alt="" />
		<a href='<?php hecho($abonnementInfo['link']) ?>' target='_blank'><?php hecho($abonnementInfo['title']) ?></a></h2>
	
	
	<div class="blog_option">
		<ul>
			
			<?php if ($isAdmin) : ?>
				<li><a  class="a_btn" href='<?php $this->Path->path("/Feed/update/{$abonnementInfo['id_f']}")?>'>Actualiser</a></li>	
				<li><a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/{$abonnementInfo['id_f']}")?>'>Forcer l'actualisation</a></li>	
			<?php endif;?>
			<li>
				<a href='<?php $this->Path->path()?>' class="a_btn">Retour au site</a>
			</li>	
			<li>
				<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doDelete' />
				<input type='hidden' name='id_f' value='<?php echo $abonnementInfo['id_f'] ?>'/>
				<input class='submit' type='submit' value='Ne plus suivre'/>
				</form>
			</li>
			<li>
				<form action='#'>
					<input class='submit option' id='tags_btn' type='submit' value='G&eacute;rer les &eacute;tiquettes'/>
				</form>
			</li>
		</ul>
		
		<div id="tags_menu">
			<?php if ($tag) : ?>
			&Eacute;tiquettes : 
				<?php foreach($tag as $one_tag): ?>
				<a href='<?php $this->Path->path("/Feed/list/0/$one_tag") ?>'><?php hecho($one_tag) ?></a>
				&nbsp;<a href='<?php $this->Path->path("/Tag/del/{$abonnementInfo['id_f']}/$one_tag") ?>' title='supprimer'>X</a>
				<?php endforeach;?>
			<?php endif;?>
			
			
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Tag/doAdd' />
				<input type='hidden' name='id_f' value='<?php echo $abonnementInfo['id_f'] ?>'/>
				<p>
					<span>Ajouter une &eacute;tiquette: </span>
					<input type='text' name='tag' value='' />
					<br/>
					<input class='a_btn' type='submit' value='Ajouter'/>
				</p>
			</form>
		</div>
		
	</div><!-- fin info_blog -->
	</div><!-- fin blog_option -->


</div><!-- fin box -->


<div class="box">

		<h2>Derniers articles</h2>
			<?php if (! $allItem) : ?>
			<div class="liste_billet">
				<div class="info">
					<p class="lien">
						Ce site ne contient aucun billet pour le moment
					</p>
				</div>
			</div>
			
			<?php endif; ?>
			<?php foreach($allItem as $i => $item) : ?>
			<div class="liste_billet<?php echo ($item['id_i']==$itemInfo['id_i'])?" billet_actif":"" ?>">
				<div class="img">
					<img class='ilu_billet' src='<?php $this->Path->echoRessourcePath("/static/img/{$item['img']}") ?>' alt=''/> 
				</div>

				<div class="info">
					<p class="date"><?php echo $this->FancyDate->get($item['date'])?></p>
					<p class="lien">
					<a href='<?php $this->Path->path("/Feed/read/{$item['id_i']}")?>'  >
							<?php hecho(strip_tags($item['title'])) ?>
					</a>
					</p>
					<p class="extrait"><?php  hecho($item['description']); ?></p>
					
				</div>
			</div>
			<?php endforeach; ?>
</div>


</div><!-- fin colonne -->

<div id="contenu" class="contenu_min">

<?php $this->LastMessage->display()?>

<?php if ($itemInfo) : ?>

<div class="info_billet">
	<div class="billet_titre">
		<h1>	<a href='<?php hecho($itemInfo['link']) ?>' target='_blank'><?php hecho($itemInfo['title'])?></a></h1>
	</div>
	<div class="billet_option">
		<ul>
			<li>
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_i' value='<?php hecho($itemInfo['id_i'])?>' />				
				<input type='submit' value='Publier sur mon mur' class="a_btn " />
			</form>
			</li>
		</ul>
	</div>
</div>

<div class="box">
	<div class="billet">
		<div class="date">publi&eacute; : <?php echo $this->FancyDate->get($itemInfo['date'])?></div>
		<?php echo $itemInfo['content'];?>
	</div>
</div>
	
	
<div class="navigation_billet">
	<div class="box_suiv_prec">
			<div class="prec"></div>
			<div class="milieu">
				<a href='<?php hecho($itemInfo['link']) ?>' target='_blank'>Lire l'article original</a>
			</div>
			<div class="suiv"></div>
		
	</div>
	<hr/>
	<div class="billet_option">
		<ul>
			<li>
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_i' value='<?php hecho($itemInfo['id_i'])?>' />				
				<input type='submit' value='Publier sur mon mur' class="a_btn " />
			</form>
			</li>			
		</ul>
	</div>

</div>
<div>
	<p >
	<span>Un problème d'affichage ?
	<a  href='<?php $this->Path->path("/Contact/index/{$itemInfo['id_i']}")?>'>Signaler un probl&egrave;me</a>
	 </span>
	</p>
</div>

<?php else: ?>
	<div class="box_info">
		Le billet n'est pas disponible.
	</div>
<?php endif;?>
	

	
</div>	
	
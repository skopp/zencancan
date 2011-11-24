<div id="colonne" class="colonne_max">

<div class="box">
	
	<div class="info_blog">
	
	<h2><img src="<?php $this->Path->echoRessourcePath("/img/commun/favicon_001.png") ?>" alt="" /><?php hecho($rssInfo['title']) ?></h2>
	
	
	<div class="blog_option">
		<ul>
			
			<?php if ($isAdmin) : ?>
			<li><a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/$id_f")?>'>Actualiser</a></li>	
			<?php endif;?>
			
			<li>
			
				<form  action='#' method='post'>
					<input class='submit' type='submit' value='Retour au site'/>
				</form>
			
			</li>	
			<li>
				<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doDelete' />
				<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
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
				&nbsp;<a href='<?php $this->Path->path("/Tag/del/$id_f/$one_tag") ?>' title='supprimer'>X</a>
				<?php endforeach;?>
			<?php endif;?>
			
			
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Tag/doAdd' />
				<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
				
				<p >
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
		
			<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
			<div class="liste_billet">
				<div class="img">
					<!-- <img src="<?php $this->Path->echoRessourcePath("/img/commun/image_001.png") ?>" alt="" />  --> 
					<img width='64px;' style='max-height: 64px;' src='<?php echo $this->ImageFinder->getFirst($itemInfo['content']) ?>' alt=''/> 
				</div>
				<div class="info">
					<p class="lien">
					<a href='<?php $this->Path->path("/Feed/read/$id_f/$i")?>'  >
							<?php hecho(strip_tags($itemInfo['title'])) ?>
					</a>
					</p>
					<p class="extrait"><?php  hecho($itemInfo['description']); ?></p>
					<p class="date"><?php echo $this->FancyDate->get($itemInfo['pubDate'])?></p>
				</div>
			</div>
			<?php endforeach; ?>
		
</div>


</div><!-- fin colonne -->

<div id="contenu" class="contenu_min">





<?php $this->LastMessage->display()?>


<div class="info_billet">
	<div class="billet_titre">
		<h1><?php hecho($resultItem['title'])?></h1>
	</div>
	<div class="billet_option">
		<ul>
			<li>
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_f' value='<?php hecho($id_f)?>' />				
				<input type='hidden' name='num_feed' value='<?php hecho($num_feed)?>' />
				<input type='submit' value='Publier sur mon mur' class="a_btn " />
			</form>
			</li>
		</ul>

	</div>
	

	
	
</div>

	<div class="box">
	<div class="billet">

		
			<div class='item_content width_min'>
				<?php echo $content_html;?>
			</div>
		
			<br/><br/>
			
			<div class="width_min align_center">

			</div>
			
			
			
			
				<?php 
			if ($rejected_tag || $rejected_attributes) : ?>
				<?php if (! $isAdmin) : ?><!--<?php endif; ?>
					<br/><br/> 
					Le document a &eacute;t&eacute; purifi&eacute; de la mani&egrave;re suivante :
					<?php if ($rejected_tag) : ?>
						<div>Les balises suivantes ont &eacute;&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_tag)?>
						</div>
					<?php endif;?>
					<?php if ($rejected_attributes) : ?>
						<div>
						Les attributs suivantes ont &eacute;t&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_attributes)?>
						</div>
					<?php endif;?>
					
					<?php if ($rejected_style) : ?>
						<div>
						Les &Atilde;&copy;l&Atilde;&copy;ments de style suivant ont &eacute;t&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_style)?>
						</div>
					<?php endif;?>
					
				<?php if (! $isAdmin) : ?> -->	<?php endif;?>
			<?php endif;?>
			
				<?php $this->render("PbAffichage");?>
			
			

		</div>
	</div>
	
	
	<div class="navigation_billet">
	

		
		<div class="box_suiv_prec">
			<div class="prec"><?php if ($num_feed > 0) : ?>
			<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed-1)); ?>'>Article pr&eacute;c&eacute;dent</a>
		<?php endif;?></div>
			<div class="milieu"></div>
			<div class="suiv"><?php if ($num_feed < count($rssInfo['item']) - 1) : ?>
			<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed+1)); ?>'>Article suivant</a>
		<?php endif;?></div>
		
		</div>
		
		<hr/>
		
		
			<div class="billet_option">
				<ul>
					<li>
					<form action='"' method='post'>
						<input type='submit' value='Option 1' class="a_btn " />
					</form>
					</li>
					
					<li>
					<form action='"' method='post'>
						<input type='submit' value='Option 2' class="a_btn " />
					</form>
					</li>
					
					<li>
					<form action='<?php $this->Path->path() ?>' method='post'>
						<?php $this->Connexion->displayTokenField(); ?>
						<input type='hidden' name='path_info' value='/Feed/doAddMur' />
						<input type='hidden' name='id_f' value='<?php hecho($id_f)?>' />				
						<input type='hidden' name='num_feed' value='<?php hecho($num_feed)?>' />
						<input type='submit' value='Publier sur mon mur' class="a_btn " />
					</form>
					</li>
					
					
				</ul>
		
			</div>
	
	
	
	</div>
	
	

	
</div>	
	
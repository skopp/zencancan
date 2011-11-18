<div id="colonne">
	<div class="breadcrumbs">
		<a class='a_btn_nav' href='<?php $this->Path->path() ?>'>&laquo; Revenir &agrave; la liste des sites</a>
	</div>
	<div class="box">
		<div class="haut"><h2>
		<a href='<?php $this->Path->path("/Feed/detail/$id_f");?>' >		
<?php hecho($rssInfo['title']) ?></a></h2></div>
		<div class="cont">
			<ul class="ul_liste_article">
				<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
					<li>
						<p><?php echo $this->FancyDate->get($itemInfo['pubDate'])?></p>
						<a href='<?php $this->Path->path("/Feed/read/$id_f/$i")?>'  title='<?php  echo get_link_title($itemInfo['content']?:$itemInfo['description']) ?>'>
							<?php hecho(strip_tags($itemInfo['title'])) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="bas"></div>				
	</div>
	<?php $this->render("FluxGestion"); ?>
</div>


<div id="contenu">
<?php $this->LastMessage->display()?>

<?php $this->render("FluxLink"); ?>

	<div class="box">
		<div class="haut">
		<h2><?php hecho($resultItem['title'])?>
		- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
		</h2>
		</div>
		
		<div class="cont">
		
			
			<div class='item_content width_min'>
				<?php echo $content_html;?>
			</div>
		
			<br/><br/>
			
			<div class="width_min align_center">
			 <form class='force_center' action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_f' value='<?php hecho($id_f)?>' />				
				<input type='hidden' name='num_feed' value='<?php hecho($num_feed)?>' />
				<input type='submit' value='Publier sur mon mur' class="submit " />
			</form>
			</div>
			
			
			<?php $this->render("FluxLink"); ?>
			
			
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
						Les éléments de style suivant ont &eacute;t&eacute; rejet&eacute; : 
						<?php echo implode(",\n",$rejected_style)?>
						</div>
					<?php endif;?>
					
				<?php if (! $isAdmin) : ?> -->	<?php endif;?>
			<?php endif;?>
			
				<?php $this->render("PbAffichage");?>
			
			
			</div>			
			
			
			<div class="bas"></div>	
		</div>
	</div>
	
	
	
<div id="colonne">
	<div class="breadcrumbs">
		<a class='a_btn_nav' href='<?php $this->Path->path() ?>'>&laquo; Revenir &agrave; la liste des sites</a>
	</div>
	<div class="box">
		<div class="haut"><h2><?php hecho($rssInfo['title']) ?></h2></div>
		<div class="cont">
			<ul class="ul_lien">
				<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
					<li>
						<div class="li_date"><?php echo $this->FancyDate->get($itemInfo['pubDate'])?></div>
						<a href='<?php $this->Path->path("/Feed/read/$id_f/$i")?>'  title='<?php  echo get_link_title($itemInfo['content']?:$itemInfo['description']) ?>'>
							<?php hecho(strip_tags($itemInfo['title'])) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="bas"></div>				
	</div>
	<?php $this->render("FluxGestion"); ?>
</div>


<div id="contenu">
<?php $this->LastMessage->display()?>

	<div class="box">
		<div class="haut">
		<h2><?php hecho($resultItem['title'])?>
		- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
		</h2>
		</div>
		
		<div class="cont">
		
			<div class="box_col">
				<p class='float_left'>
				<a href='<?php $this->Path->path("/Feed/detail/$id_f");?>' >&laquo; Revenir &agrave; la liste des articles</a>
				</p>
				<p class='float_right'>
				<?php if ($resultItem['link']) : ?>
					<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original &raquo;</a>
				<?php endif;?>
				</p>
			</div>
			<div class='item_content'>
				<?php echo $content_html;?>
			</div>
			<?php 
			if ($rejected_tag || $rejected_attributes) : ?>
				<?php if (! $isAdmin) : ?><!--<?php endif; ?> 
					<div>Le document a été purifié de la manière suivante :
					<?php if ($rejected_tag) : ?>
						Les balises suivantes ont été rejeté : 
						<?php echo implode(",\n",$rejected_tag)?>
					<?php endif;?>
					
					<?php if ($rejected_attributes) : ?>
						Les attributs suivantes ont été rejeté : 
						<?php echo implode(",\n",$rejected_attributes)?>
					<?php endif;?>
					</div>  
				<?php if (! $isAdmin) : ?> -->	<?php endif;?>
			<?php endif;?>
			<br/><br/>
			 <form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAddMur' />
				<input type='hidden' name='id_f' value='<?php hecho($id_f)?>' />				
				<input type='hidden' name='num_feed' value='<?php hecho($num_feed)?>' />
				<input type='submit' value='Publier sur mon mur' class="a_btn" />
			</form>
			
			</div>			
			<div class="bas"></div>	
		</div>
	</div>

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
							<?php echo strip_tags($itemInfo['title']) ?>
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
				<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original &raquo;</a>
				</p>
			</div>
			<div class='item_content'>
				<?php echo $content_html;?>
			</div>
			<?php 
			if ($rejected_tag || $rejected_attributes) : ?>
				<div>
					Le document a été purifié de la manière suivantes :
					<?php if ($rejected_tag) : ?>
						<p>Les balises suivantes ont été rejeté : <?php echo implode(",",$rejected_tag)?></p>
					<?php endif;?>
					<?php if ($rejected_attributes) : ?>
						<p>Les attributs suivantes ont été rejeté : <?php echo implode(",",$rejected_attributes)?></p>
					<?php endif;?>  
				</div>	
			<?php endif;?>
			
			</div>			
			<div class="bas"></div>	
		</div>
	</div>

<div id="colonne">
	<div class="breadcrumbs">
		<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir a la liste des sites</a>
	</div>
	<div class="box">
		<div class="haut"><h2><?php hecho($rssInfo['title']) ?></h2></div>
		<div class="cont">
			<ul class="ul_lien">
				<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
					<li>
						<?php echo $this->FancyDate->get($itemInfo['pubDate'])?>
						<a href='read.php?id=<?php hecho($id)?>&amp;id_f=<?php echo $id_f?>&amp;item=<?php echo urlencode($itemInfo['id_item'])?>'  title='<?php  echo get_link_title($itemInfo['content']?:$itemInfo['description']) ?>'>
							<?php echo strip_tags($itemInfo['title']) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="bas"></div>				
	</div>
</div><!-- fin colonne -->


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
				<a href='feed.php?id=<?php hecho($id)?>&amp;id_f=<?php echo $id_f?>'>&laquo; Revenir aux articles de  <?php hecho($rssInfo['title']) ?></a>
				</p>
				<p class='float_right'>
				<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original &raquo;</a>
				</p>
			</div>
			
	
			<div class='item_content'>
				<p>
				<?php echo $content_html;?>
				</p>
			</div>
			
		</div>
		<div class="bas"></div>				
	</div>

</div><!-- fin contenu -->




<div id="contenu">
<div class="breadcrumbs">
	<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir à la liste des sites</a>
</div>

<div class="box">
	<div class="haut">
	<h2><?php hecho($resultItem['title'])?>
	- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
	</h2>
	</div>
	<div class="cont">
	
		<a href='feed.php?id=<?php hecho($id)?>&id_f=<?php echo $id_f?>'>&laquo; Revenir aux articles de  <?php hecho($rssInfo['title']) ?></a>
		
		<p class='align_right'>
		<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original &raquo;</a>
		</p>
		<div class='item_content'>
			<?php echo $content_html;?>
		</div>
	</div>
	<div class="bas"></div>				
</div>
</div>

<div id="colonne">
<div class="box">
	<div class="haut"><h2><?php hecho($rssInfo['title']) ?></h2></div>
	<div class="cont">
		<ul class="ul_lien">
			<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
				<li>
					<?php echo $this->FancyDate->get($itemInfo['pubDate'])?>
					<a href='read.php?id=<?php hecho($id)?>&id_f=<?php echo $id_f?>&item=<?php echo urlencode($itemInfo['id_item'])?>'  title='<?php  echo get_link_title($itemInfo['content']?:$itemInfo['description']) ?>'>
						<?php echo strip_tags($itemInfo['title']) ?>
					</a>
				</li>
	
			<?php endforeach; ?>
		</ul>
	</div>
<div class="bas"></div>				
</div>
</div>
<div id="colonne">
	<div class="breadcrumbs">
		<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir &agrave; la liste des sites</a>
	</div>
	<div class="box">
		<div class="haut"><h2>Gestion</h2>
		</div>
		<div class="cont">
		
		<?php if ($info['tag']) : ?>
		Cat&eacute;gorie actuelle : <a href='index.php?id=<?php hecho($id)?>&tag=<?php hecho($info['tag']) ?>'><?php hecho($info['tag']) ?></a>
		<?php endif;?>
		
		<form class='ff' method='post' action='aggregate.php'>
			
			<input type='hidden' name='id' value='<?php echo $id ?>'/>
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
			<p>
			Cat&eacute;gorie : <input type='text' name='tag' value='<?php hecho($info['tag']) ?>' />
			</p>
			<p><input class='submit' type='submit' value='Mettre dans une cat&eacute;gorie'/>	</p>
		</form>
		<form method='post' action='del.php'>
			<p>
			<input class='submit' type='submit' value='Supprimer le suivi de ce site'/>
			</p>
			<input type='hidden' name='id' value='<?php echo $id ?>'/>
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
		</form>
		</div>
		<div class="bas"></div>				
		</div>
</div><!-- fin colonne -->


<div id="contenu">



	
<?php $this->LastMessage->display()?>
	
<div class="box">
	<div class="haut">
	<h2>Derni&egrave;res mises &agrave; jour de <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a></h2>
	</div>
	<div class="cont">	
	<?php if (! $content ) : ?>
		<div class='box_error'>Un probl&egrave;me est survenu sur la r&Atilde;&copy;cuperation de ce flux</div>
	<?php endif;?>

	<table>
	<?php foreach($rssInfo['item'] as $i => $flux) : ?>
		<tr class="<?php echo $i%2?"":"bgcolor01";?>">
			<td class='date' width='80'><?php echo $this->FancyDate->get($flux['pubDate'])?></td>
			<td class='lien'>
				<a href='read.php?id=<?php hecho($id) ?>&amp;id_f=<?php echo $id_f ?>&&amp;item=<?php echo urlencode($flux['id_item'])?>' title='<?php  echo get_link_title($flux['content']?:$flux['description']) ?>'>
					<?php echo strip_tags($flux['title']) ?>
				</a>
				<a href='<?php hecho($flux['link'])?>' target='_blank' title="Ouvrir l'article original">
					&raquo;
				</a>
			<br/>
		</td>
		</tr>
	<?php endforeach;?>
	</table>
	</div>
	<div class="bas"></div>				
</div>


</div><!-- fin contenu -->




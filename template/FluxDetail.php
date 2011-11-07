<div id="colonne">
	<div class="breadcrumbs">
		<a class="a_btn_nav" href='<?php $this->Path->path() ?>'>&laquo; Revenir a la liste des sites</a>
	</div>
	<?php $this->render("FluxGestion"); ?>
</div><!-- fin colonne -->


<div id="contenu">

<?php $this->LastMessage->display()?>
<div class="box">
	<div class="haut">
	<h2>Derni&egrave;res mises &agrave; jour de <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a></h2>
	</div>
	<div class="cont">	
	<?php if (! $content ) : ?>
		<div class='box_error'>Un probl&egrave;me est survenu sur la récuperation de ce flux</div>
	<?php endif;?>

	<table>
	<?php foreach($rssInfo['item'] as $i => $flux) : ?>
		<tr class="<?php echo $i%2?"":"bgcolor01";?>">
			<td class='date' width='80'><?php echo $this->FancyDate->get($flux['pubDate'])?></td>
			<td class='lien'>
				<a href='<?php $this->Path->path("/Feed/read/$id_f/$i") ?>' title='<?php  echo get_link_title($flux['content']?:$flux['description']) ?>'>
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




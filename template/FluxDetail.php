<div id="colonne">
	<div class="box">
	<h2>Retour</h2>
	<p>
		<a class="a_btn_nav" href='<?php $this->Path->path() ?>'>&laquo; Revenir &agrave; la liste des sites</a>
	</p>
	</div>
	
	<?php $this->render("FluxGestion"); ?>

</div><!-- fin colonne -->


<div id="contenu">

<div class="box">

	<?php $this->LastMessage->display()?>

	<h1>Derni&egrave;res mises &agrave; jour de <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a></h1>


	<?php if (! $content ) : ?>
		<div class='box_error'>Un probl&egrave;me est survenu sur la récuperation de ce flux</div>
	<?php endif;?>

	<table>
	<?php foreach($rssInfo['item'] as $i => $flux) : ?>
		<tr>
			<td class='lien'>
				<a href='<?php $this->Path->path("/Feed/read/$id_f/$i") ?>' title='<?php hecho($flux['description']); ?>'>
					<?php hecho(strip_tags($flux['title'])) ?>
				</a>
				<a href='<?php hecho($flux['link'])?>' target='_blank' title="Ouvrir l'article original (nouvelle fenêtre)">
					&raquo;
				</a>
		</td>
		<td class='date'><?php echo $this->FancyDate->get($flux['pubDate'])?></td>
		</tr>
	<?php endforeach;?>
	</table>
	<?php $this->render("PbAffichage");?>
	
</div>


</div><!-- fin contenu -->

	
	
		


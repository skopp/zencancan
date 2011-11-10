<div class="box_suiv_prec width_min">

	<div class='prec'>
	<?php if ($num_feed > 0) : ?>
		<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed-1)); ?>'>Article pr&eacute;c&eacute;dent</a>
	<?php endif;?>
	</div>
	
	<div class='milieu'>
	<?php if ($resultItem['link']) : ?>
		<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original</a>
	<?php endif;?>
	</div>
	<div class='suiv'>
	<?php if ($num_feed < count($rssInfo['item']) - 1) : ?>
		<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed+1)); ?>'>Article suivant</a>
	<?php endif;?>
	</div>
</div>

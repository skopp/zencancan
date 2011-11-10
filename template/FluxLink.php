<div class="box_col">

	<p class='float_left'>
	<?php if ($num_feed > 0) : ?>
		<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed-1)); ?>' >&laquo; Article précédent</a>
	<?php endif;?>
	</p>
	
	<p class='float_milieu'>
	<?php if ($resultItem['link']) : ?>
		<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original</a>
	<?php endif;?>
	</p>
	<p class='float_right'>
	<?php if ($num_feed < count($rssInfo['item']) - 1) : ?>
		<a href='<?php $this->Path->path("/Feed/read/$id_f/".($num_feed+1)); ?>' >Article suivant &raquo;</a>
	<?php endif;?>
	</p>
</div>

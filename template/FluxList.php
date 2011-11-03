
<div id="contenu_unique">
<?php $this->LastMessage->display(); ?>

<?php if ($allFlux) : ?>
<div class="box">
	<div class="haut">
		<h2>Derni&egrave;res mises &agrave; jour<?php echo $tag?" dans la cat&eacute;gorie $tag":""?></h2>
	</div>
	<div class="cont">
	
		<?php if ($tag) : ?>
			<a class='a_btn_nav' href='<?php $this->Path->path("/Feed/list/")?>'>&laquo; Revenir &agrave; la liste des sites</a>
		<?php endif;?>
		
		<?php if ($offset) : ?>
			<a class='a_btn_nav' href='<?php $this->Path->path("/Feed/list/".($offset - $nbAfficher) ."/$tag") ?>'>	
				&laquo; Sites mis &agrave; jour plus r&eacute;cemment
			</a>
		<?php endif;?>
			<table>
<?php foreach($allFlux as $i => $flux) : ?>
	<tr class="<?php echo $i%2?"":"bgcolor01";?>">
		<td class='date'><a title='Dernier passage : <?php echo $this->FancyDate->get($flux['last_recup'])?>'><?php echo $this->fancyDate->get($flux['last_maj'])?></a></td>
		<td class='tag'>
		<?php if(! $tag): ?>
			<a href='<?php $this->Path->path("/Feed/list/0/".urlencode($flux['tag'])) ?>'><?php echo $flux['tag'] ?></a>
		<?php endif;?>
		</td>
		
		<td class='site'><a href='<?php $this->Path->path("/Feed/detail/{$flux['id_f']}/") ?>' title='<?php hecho($flux['title'])?>'><?php hecho(wrap($flux['title'],25,2))?></a></td>
	
		<td class='lien' style='border-bottom:1px solid #fff;'>
		<a href='<?php $this->Path->path("/Feed/read/{$flux['id_f']}/0") ?>' title='<?php  echo get_link_title($flux['item_content']) ?>'>
				<?php hecho($flux['item_title']) ?>
			</a>
			<?php if ($flux['item_link']) : ?>
			<a href='<?php hecho($flux['item_link'])?>' target='_blank' title="Ouvrir l'article original">
			
				&raquo;
			</a>
			<?php endif;?>
			</td>		
	</tr>
<?php endforeach;?>
</table>
		<?php if ($offset + $nbAfficher < $nbFlux) : ?>
			<a href='<?php $this->Path->path("/Feed/list/".($offset + $nbAfficher) ."$tag") ?>'>	
				Sites mis &agrave; jour avant &raquo;
			</a>
		<?php endif;?>
	</div>
	<div class="bas"></div>				
</div>
<?php else: ?>
<div class="box">
	<div class="haut">
	<h2>Suivi des sites</h2>
	</div>
	<div class="cont">
	
	<div class="box_info">
	<p>Vous ne suivez actuellement aucun site.</p>
	<p>Pour suivre un site, inscrivez son nom dans le formulaire ci-dessus.</p>
	</div>
</div>
<div class="bas"></div>				
</div>

<?php endif;?>

</div>

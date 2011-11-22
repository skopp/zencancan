
<div id="contenu_unique">
<?php $this->LastMessage->display(); ?>

<?php if ($allFlux) : ?>
<div class="box">
	<div class="haut">
		<h2>Derni&egrave;res mises &agrave; jour<?php echo $tag?" avec l'étiquette $tag":""?></h2>
		<?php $this->SuivantPrecedent->display(); ?>
	</div>
	<div class="cont">
	
		<?php if ($tag) : ?>
			<a class='a_btn_nav' href='<?php $this->Path->path("/Feed/list/")?>'>&laquo; Revenir &agrave; la liste des sites</a>
		<?php endif;?>
		
			<table>
<?php foreach($allFlux as $i => $flux) : ?>
	<tr class="<?php echo $i%2?"":"bgcolor01";?>">
		<td><a title='Dernier passage : <?php echo $this->FancyDate->get($flux['last_recup'])?>'><?php echo $this->fancyDate->get($flux['last_maj'])?></a></td>
		<td class='tag'>
		<?php foreach($flux['tag'] as $one_tag) : ?>
			<a href='<?php $this->Path->path("/Feed/list/0/".urlencode($one_tag)) ?>'><?php echo $one_tag ?></a>
		<?php endforeach;?>
		</td>
		
		<td class='site'><a href='<?php $this->Path->path("/Feed/detail/{$flux['id_f']}/") ?>' title='<?php hecho($flux['title'])?>'><?php hecho(wrap($flux['title'],25,2))?></a></td>
	
		<td class='lien'>
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
		<?php $this->SuivantPrecedent->display(); ?>
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

<div id="colonne">
	<div class="box">
		<h2>Mes &eacute;tiquettes</h2>
		<ul class="ul_tag">
			<li><a href="<?php $this->Path->path("/Feed/list")?>" title="Tous">
							Tous
				</a>
			</li>
			<?php foreach($all_tag as $i => $the_tag) : ?>
				<li>
					<a href="<?php $this->Path->path("/Feed/list/0/" . strtr($the_tag,array(" " => "%20")) )?>"  
							title="<?php  hecho($the_tag); ?>">
							<?php hecho($the_tag) ?>
						</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<div id="contenu">

<h1><?php echo $this->Authentification->getFullAccountName() ?><?php echo $tag?" : $tag":""?></h1>


<?php $this->LastMessage->display(); ?>

<?php if ($allFlux) : ?>
<div class="box">
	<?php $this->SuivantPrecedent->display(); ?>
	


<table class='tableSite'>
<?php foreach($allFlux as $i => $flux) : ?>
	<tr class="siteTR">
		<td class="favicon"><img width='16' height='16' src="<?php $flux['favicon']?$this->Path->echoRessourcePath("/static/favicon/{$flux['favicon']}"):$this->Path->echoRessourcePath("/img/commun/no_favicon.png") ?>" alt="" /></td>
		<td class='blog'><?php hecho(wrap($flux['title'],25,1))?></td>
		<td>
			<?php if ($flux['last_id_i']) : ?>
				<a href='<?php $this->Path->path("/Feed/read/{$flux['last_id_i']}") ?>' title='<?php  hecho($flux['item_description']) ?>'>
					<?php hecho($flux['item_title']) ?>
				</a>
			<?php else : ?>
				<a href='<?php $this->Path->path("/Feed/detail/{$flux['id_f']}") ?>'>
					Ce flux n'a pas encore &eacute;t&eacute; r&eacute;cup&eacute;r&eacute;
				</a>
			<?php endif; ?>			
		</td>
				
		<td class='tag'>
		<?php foreach($flux['tag'] as $one_tag) : ?>
			<?php echo $one_tag ?>
		<?php endforeach;?>
		</td>
		<td class='date'>
			<?php if($flux['last_id_i']) : ?>
				<?php echo $this->FancyDate->get($flux['last_maj'])?>
			<?php endif;?>
		</td>
	</tr>
<?php endforeach;?>
</table>

<?php $this->SuivantPrecedent->display(); ?>
	
</div>
<?php else: ?>
<div class="box">
	
	<h2>Suivi des sites</h2>
	
	<div class="box_info">
	<p>Vous ne suivez actuellement aucun site.</p>
	<p>Pour suivre un site, inscrivez son nom dans le formulaire ci-dessus.</p>
</div>
<div class="bas"></div>				
</div>

<?php endif;?>

</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".siteTR").click( function(event){
			window.location.href = $(this).find("a").attr("href");

		});
			
	});
</script>


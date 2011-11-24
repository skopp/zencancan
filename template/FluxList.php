<div id="colonne">
	<div class="box">
		<h2>Mes étiquettes</h2>
		<ul>
			<li><a href='<?php $this->Path->path("/Feed/list")?>' title='Tous'>
							Tous
				</a></li>
			<?php foreach($all_tag as $i => $the_tag) : ?>
				<li>
					<a href='<?php $this->Path->path("/Feed/list/0/$the_tag")?>'  
							title='<?php  hecho($the_tag); ?>'>
							<?php hecho($the_tag) ?>
						</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<!-- <div class="box">
		<h2>Mes sites</h2>
		<ul class="site_list">
			<?php for ( $i=1; $i < 10 ; $i++ ) : ?>
			<li><a href="#"><img src="img/commun/favicon_001.png" alt="" />Zagaz blog</a></li>
			<?php endfor; ?>
		</ul>
	</div> -->
</div>

<div id="contenu">

<h1><?php echo $this->Authentification->getFullAccountName() ?><?php echo $tag?" : $tag":""?></h1>


<?php $this->LastMessage->display(); ?>

<?php if ($allFlux) : ?>
<div class="box">
	<?php $this->SuivantPrecedent->display(); ?>
	
		
<table>

<?php for ( $i=1; $i < 10 ; $i++ ) : ?>
<tr>
<td class="favicon"><img src="img/commun/favicon_001.png" alt="" /></td>
<td class="blog">titre du blog</td>
<td><a href="billet.php">Article du blog blablbalblblaa</a></td>
<td class="tag">toto, lolopopop</td>
<td class="date">10h20</td>
</tr>
<?php endfor; ?>
</table>
<table>
<?php foreach($allFlux as $i => $flux) : ?>
	<tr>
		<td class="favicon"><img src="img/commun/favicon_001.png" alt="" /></td>
		<td class='blog'><a href='<?php $this->Path->path("/Feed/read/{$flux['id_f']}/0") ?>' title='<?php hecho($flux['title'])?>'><?php hecho(wrap($flux['title'],25,2))?></a></td>
		<td >
			<a href='<?php $this->Path->path("/Feed/read/{$flux['id_f']}/0") ?>' title='<?php  echo get_link_title($flux['item_content']) ?>'>
				<?php hecho($flux['item_title']) ?>
			</a>
			<?php if ($flux['item_link']) : ?>
			<a href='<?php hecho($flux['item_link'])?>' target='_blank' title="Ouvrir l'article original">
			
				&raquo;
			</a>
			<?php endif;?>
		</td>		
		<td class='tag'>
		<?php foreach($flux['tag'] as $one_tag) : ?>
			<a href='<?php $this->Path->path("/Feed/list/0/".urlencode($one_tag)) ?>'><?php echo $one_tag ?></a>
		<?php endforeach;?>
		</td>
		<td class='date'><a title='Dernier passage : <?php echo $this->FancyDate->get($flux['last_recup'])?>'><?php echo $this->fancyDate->get($flux['last_maj'])?></a></td>
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

<div id="colonne" class="colonne_max">
</div>

<div id="contenu" class="contenu_min">

	
	<div class="info_billet" style="margin-top:0;">
		<div class="billet_titre">
		<?php if ($this->Connexion->isConnected()) : ?>
			<h1>Mon mur</h1>
		<?php else : ?>
			<h1><?php hecho($name_account) ?> - Mur </h1>
		<?php endif;?>
		</div>
		
	<div class="billet_option">
		<ul>
			<li>
			<?php if($this->Connexion->isConnected()) : ?> 
			<form action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Mur/doAdd' />
				<label for="id_quoideneuf">Quoi de neuf ?</label>
				<input class='quoideneuf' id='id_quoideneuf' type='text' size='40' name='content' />
				<input type='submit' value='Ajouter' class="a_btn" />
			</form>
		
			<?php endif;?>
			</li>
		</ul>
	</div>
		
	</div>	
				
	<div class="box">
		
			<?php foreach($all_item as $item) : ?>
				
				
				<div class="item_wall">
				
					<table>
					<tr>
					<?php if($item['img']): ?>
					<td width="80">
						<img src='<?php echo $item['img']?>' alt='<?php hecho($item['title'])?>'/>
					</td>
					<?php endif;?>
					
					<td>
					
						<?php if ($item['link']) : ?>
							<h2><a href='<?php hecho($item['link'])?>'><?php hecho($item['title'])?></a></h2>
						<?php else : ?>
							<h2><?php hecho($item['title'])?></h2>
						<?php endif;?>
					
						<?php echo $item['description']; ?>
						<a href='<?php hecho($item['link'])?>' target='_blank'>Lire la suite</a>
					</td>
					
					<td class="date">
						<?php echo $this->FancyDate->get($item['date'])?>
					</td>
					
					<?php if ($this->Connexion->isConnected()) : ?>
					<td width="16">
						<a class='tooltip' title='Retirer du mur' href='<?php $this->Path->path("/Mur/doDelete/{$item['id_m']}");?>'><img src="<?php $this->Path->echoRessourcePath("/img/commun/ilu_del_blog.png") ?>" alt="Supprimer" /></a>
					</td>
					<?php endif;?>
					</tr>
					</table>
				</div>
				
				
			<?php endforeach;?>
		
		<?php $this->SuivantPrecedent->display(); ?>


	</div>
</div>



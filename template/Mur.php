<div id="colonne">
</div>

<div id="contenu">

	<div class="box">
		<div class="haut">
		<?php if ($this->Connexion->isConnected()) : ?>
			<h2>Mon mur</h2>
		<?php else : ?>
			<h2><?php hecho($name_account) ?> - Mur </h2>
		<?php endif;?>
		</div>
		<div class="cont">
		
			<?php if($this->Connexion->isConnected()) : ?> 
			<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Mur/doAdd' />
				Quoi de neuf ?  <br/>
				<input type='text' size='50' name='content' />
				<input type='submit' value='Ajouter' class="a_btn" />
			</form>
		
			<?php endif;?>
			<?php foreach($all_item as $item) : ?>
				<div class='item_wall'>
				
				
				<?php if ($item['link']) : ?>
					<h3><a href='<?php hecho($item['link'])?>'><?php hecho($item['title'])?></a></h3>
				<?php else : ?>
					<h3><?php hecho($item['title'])?></h3>
				<?php endif;?>
				
				
					<?php echo $item['content']; ?>
						<div class="col">
						<p class="float_left discret"><?php echo $this->FancyDate->get($item['date'])?></p>
						<?php if ($this->Connexion->isConnected()) : ?>
						<p class="float_right"><a class="discret" href='<?php $this->Path->path("/Mur/doDelete/{$item['id_m']}");?>'>Supprimer</a></p>
						</div>
					<?php endif;?>

				</div>
			<?php endforeach;?>
		
		</div>
						
		<div class="bas"></div>	
	</div>
</div>



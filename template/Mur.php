<div id="colonne">
</div>

<div id="contenu">

	<div class="box">
		<div class="haut">
			<h2>Mon mur</h2>
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
			<?php else: ?>
				<?php hecho($name_account)?>
			<?php endif;?>
			<?php foreach($all_item as $item) : ?>
				<div class='mur_item'>
					<h3><a href='<?php hecho($item['link'])?>'><?php hecho($item['title'])?></a></h3>
					<?php echo $item['content']; ?>
					<p class='petit'><?php echo $this->FancyDate->get($item['date'])?>
					<?php if ($this->Connexion->isConnected()) : ?>
						&nbsp;-&nbsp;<a href='<?php $this->Path->path("/Mur/doDelete/{$item['id_m']}");?>'>Supprimer</a>
					<?php endif;?>
					</p>
				</div>
			<?php endforeach;?>
		
		</div>
						
		<div class="bas"></div>	
	</div>
</div>



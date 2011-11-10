<div class="box">
	
		<div class="cont">
		
		<?php if ($tag) : ?>
		Cat&eacute;gorie actuelle : <a href='<?php $this->Path->path("/Feed/list/0/$tag") ?>'><?php hecho($tag) ?></a>
		<?php endif;?>
		
		
		<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doAggregate' />
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
			
			<p class="align_center">
			<span>Mettre dans une cat&eacute;gorie</span>
			<input type='text' name='tag' value='<?php hecho($tag) ?>' />
			<br/>
			<input class='a_btn' type='submit' value='Enregistrer'/>
			</p>
		</form>
		
		
		<form class="ff" action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doDelete' />
			
			<p class="align_center">
			<span>D&eacute;sabonnement</span><br/>
			<input class='submit' type='submit' value='Ne plus suivre'/>
			</p>
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
		</form>
		
		
		
		<div class="ff">
		
		<?php if ($isAdmin) : ?>
		<a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/$id_f")?>'>Actualiser</a>
		<br/>
		<?php endif;?>
		<p class="align_center">
		<span>Cette page n'est pas conforme</span><br/>
		<a class="a_btn" href='<?php $this->Path->path("/Contact/index/$id_f")?>'>Signaler un probl&egrave;me</a>
		</p>
		</div>
		
		
		</div>
</div>
		
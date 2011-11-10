<div class="box">
	
		<div class="cont">
		
		<?php if ($tag) : ?>
		Cat&eacute;gorie actuelle : <a href='<?php $this->Path->path("/Feed/list/0/$tag") ?>'><?php hecho($tag) ?></a>
		<?php endif;?>
		
		<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doAggregate' />
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
			<p>
			Cat&eacute;gorie : <input type='text' name='tag' value='<?php hecho($tag) ?>' />
			</p>
			<p><input class='submit' type='submit' value='Mettre dans une cat&eacute;gorie'/>	</p>
		</form>
		<form action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doDelete' />
			<p>
			<input class='submit' type='submit' value='Ne plus suivre'/>
			</p>
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
		</form>
		
		<?php if ($isAdmin) : ?>
		<a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/$id_f")?>'>Acualiser</a>
		<br/>
		<?php endif;?>
		<a  class="a_btn" href='<?php $this->Path->path("/Contact/index/$id_f")?>'>Signaler un problème</a>
		</div>
		<div class="bas"></div>				
		</div>
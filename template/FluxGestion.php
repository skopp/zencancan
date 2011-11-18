<div class="box">
	
		<div class="cont">
		
		<?php if ($isAdmin) : ?>
			<a  class="a_btn" href='<?php $this->Path->path("/Feed/forceReload/$id_f")?>'>Actualiser</a>
			<br/>
		<?php endif;?>
		
		
		<?php if ($tag) : ?>
		&Eacute;tiquettes : 
			<?php foreach($tag as $one_tag): ?>
			<a href='<?php $this->Path->path("/Feed/list/0/$one_tag") ?>'><?php hecho($one_tag) ?></a>
			&nbsp;<a href='<?php $this->Path->path("/Tag/del/$id_f/$one_tag") ?>' title='supprimer'>X</a>
			<?php endforeach;?>
		<?php endif;?>
		
		
		<form action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Tag/doAdd' />
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
			
			<p >
			<span>Ajouter une &eacute;tiquette: </span>
			<input type='text' name='tag' value='' />
			<br/>
			<input class='a_btn' type='submit' value='Ajouter'/>
			</p>
		</form>
		
		
		<form  action='<?php $this->Path->path() ?>' method='post'>
			<?php $this->Connexion->displayTokenField(); ?>
			<input type='hidden' name='path_info' value='/Feed/doDelete' />
			
			<p>
			
			<input class='submit' type='submit' value='Ne plus suivre'/>
			</p>
			<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
		</form>
		
		</div>
</div>
		
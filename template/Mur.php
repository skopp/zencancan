<div id="colonne">
</div>

<div id="contenu">

	<div class="box">
		<div class="haut">
			<h2>Mon mur</h2>
		</div>
		<div class="cont">
		
			<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Mur/doAdd' />
				Quoi de neuf ?  <br/>
				<input type='text' size='50' name='content' />
				<input type='submit' value='Ajouter' class="a_btn" />
				
			</form>
		
		</div>
						
		<div class="bas"></div>	
	</div>
</div>



<div class="box">
	
		<div class="cont">
		
		
		
	
		
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
		
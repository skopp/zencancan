	<?php $this->render("Menu");?>

	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Contact</h2></div>
			<div class="cont">
			<p>Une remarque ? Un bug ? Une demande d'&eacute;volution ? 
			N'h&eacute;sitez pas &agrave; utiliser le formulaire ci-dessous pour nous
			faire part de votre question.</p>
			<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Contact/doContact' />							
				<label for="sujet">Sujet</label>
				<input type="text" name="sujet" id="sujet" size='40' />
				<hr/>
				
				
				<label for="email">Votre email</label>
				<input type="text" name="email" id="email" size='40'  />
				<hr/>
				
				<label for="question">Votre question</label>
				<textarea name="question" id="question" cols='40' rows='12'></textarea>
				<hr/>
		
				
								<p class="align_right">
				<input type="submit" class="submit" />
				</p>
				
				</form>
			
			</div>
			<div class="bas"></div>				
		</div>
		
	

	</div><!-- fin contenu -->
	
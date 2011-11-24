	<?php $this->render("Menu");?>

	<div id="contenu">
	
		<h1>Contactez-nous</h1>
	
		<div class="box">
			<form class='ff' action='<?php $this->Path->path() ?>' method='post'>
			<h2>Formulaire de contact</h2>
			<hr/>
			
			
			<div class="box_info">
			Une remarque ? Un bug ? Une demande d'&eacute;volution ? 
			N'h&eacute;sitez pas &agrave; utiliser le formulaire ci-dessous pour nous
			faire part de votre question.
			</div>
			
			
			<?php $this->LastMessage->display()?>
			
			
			
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Contact/doContact' />							
				
				<p>
				<label for="sujet">Sujet</label>
				<input type="text" name="sujet" id="sujet" size='40' value='<?php echo $this->LastMessage->getLastInput('sujet') ?>'/>
				</p>
				
				<p>
				<label for="email">Votre email</label>
				<input type="text" name="email" id="email" size='40'  value='<?php echo $this->LastMessage->getLastInput('email') ?>'/>
				</p>
				
				<p>
				<label for="question">Votre question</label>
				<textarea name="question" id="question" cols='60' rows='25'><?php echo $this->LastMessage->getLastInput('question') ?></textarea>
				</p>
				
				<input type="submit" class="submit" />
				
				
				</form>
			
			</div>
			<div class="bas"></div>				
		</div>
		
	

	</div><!-- fin contenu -->
	
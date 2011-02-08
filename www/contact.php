<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());


$pageHTML->haut();
$pageHTML->menu();
?>
	
	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Contact</h2></div>
			<div class="cont">
			<p>Une remarque ? Un bug ? Une demande d'évolution ? 
			N'hésitez pas à utiliser le formulaire ci-dessous pour nous
			faire part de votre question.</p>
			<form action="contact-controler.php" method='post'>
							
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
	

<?php 
$pageHTML->bas();




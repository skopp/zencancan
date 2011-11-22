<?php
$page = "form";
$titre_h1 = "Titre de niveau H1";
?>

<?php include('_haut.php'); ?>

<h1>Titre du billet en H1</h1>

<div class="box">


<form action="#" class="ff">

<h2>H2 dans formulaire</h2>
<hr/>

				<p>
				<label for="pseudo">Pseudo*</label>
				<input id="pseudo" name="pseudo" value="" type="text"/>
				</p>
				<p>
				<label for="mdp">Mot de passe*</label>
				<input id="mdp" name="mdp" value="" type="password"/>
				</p>
				
				<p>
				<label for="listbox">liste box</label>
				<select name="listbox" id="listbox">
					<option value="0">option 1</option>
					<option value="0">option 1</option>
					<option value="0">option 1</option>										
				</select>
				</p>
				
				<p>
				<label for="mdp2">Re-saisir mot de passe*</label>
				<input id="mdp2" name="mdp2" value="" type="password"/>
				</p>
				
				<p>
				<label for="case" class="case">case à cocher*</label>
				<input id="case" name="case" value="" type="checkbox"/>
				</p>
				
				<p class="last">
				<label for="email">Adresse e-mail*</label>
				<input id="email" name="email" value="" type="text"/>
				</p>
				
				<div class="align_right">
					<input class="submit" value="Rejoindre Le Mans" type="submit"/>
				</div>

</form>


</div>





<?php include('_bas.php'); ?>
				
				
				
				
				
				
				
				
				

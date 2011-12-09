<?php $this->render("Menu");?>
<div id="contenu">
<div class="box">
	<div class="haut">
		<h2>Statistiques</h2>
	</div>
	<div class="cont">
		Nombres d'abonn&eacute;s : <?php echo $this->AbonnementSQL->getNbAbo();?><br/>
		Nombres de compte: <?php echo $this->UtilisateurSQL->getNbAccount();?><br/>
		Nombre de flux : <?php echo $infoFeed['nb'] ?><br/>
		R&eacute;cup&eacute;ration du dernier flux : <?php echo $infoFeed['max_date'] ?><br/>
		Age de la plus veille récuperation : <?php echo $infoFeed['min_date'] ?><br/>
	</div>
	<div class="bas"></div>				
</div>
</div>

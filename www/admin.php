<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");
require_once("AbonnementSQL.class.php");
require_once("FeedSQL.class.php");

if ( ! $compte->isAdmin($authentification->getId())){
	header("Location: index.php");
	exit;
}
$abonnementSQL = new AbonnementSQL($sqlQuery);

$feedSQL = new FeedSQL($sqlQuery);
$infoFeed = $feedSQL->feedInfo();

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount(),$compte->isAdmin($authentification->getId()));

$pageHTML->haut();
?>


<div class="box">
	<div class="haut">
		<h2>Statistiques</h2>
	</div>
	<div class="cont">
		Nombres d'abonnés : <?php echo $abonnementSQL->getNbAbo();?><br/>
		Nombres de compte: <?php echo $compte->getNbAccount();?><br/>
		Nombre de flux : <?php echo $infoFeed['nb'] ?><br/>
		Récupération du dernier flux : <?php echo $infoFeed['date'] ?><br/>
		
	</div>
	<div class="bas"></div>				
</div>
<?php 
$pageHTML->bas();





<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");
require_once("AbonnementSQL.class.php");
require_once("FancyDate.class.php");
require_once("util.php");
require_once("Paginator.class.php");
require_once("FeedHTML.class.php");

$recuperateur = new Recuperateur($_GET);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$fancyDate = new FancyDate();

$offset = $recuperateur->getInt('offset',0);
$tag = $recuperateur->get('tag');

$allFlux = $abonnementSQL->get($id,$tag,$offset);
$nbFlux = $abonnementSQL->getNbFlux($id,$tag);

$paginator = new Paginator($nbFlux,AbonnementSQL::NB_DISPLAY,$offset);
$paginator->setLink("index.php?id=$id&tag=$tag");

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount(),$compte->isAdmin($authentification->getId()));
$pageHTML->addRSSURL("Votre flux zencancan","rss.php?id=$id");
if ($tag){
	$pageHTML->addRSSURL("Votre flux zencancan - $tag","rss.php?id=$id&tag=$tag");
}

$feedHTML = new FeedHTML($fancyDate);

$pageHTML->haut();
?>

<div id="contenu">

<?php if ($lastMessage->getLastMessage()) : ?>
<div class="<?php echo $lastMessage->getLastMessageType()==LastMessage::ERROR?'box_error':'box_confirm'?>"><p>
<?php echo $lastMessage->getLastMessage(); ?>
</p></div>
<?php endif;?>
	

<form action='add-flux.php' method='post'>
<input type='hidden' name='id'  value='<?php hecho($id) ?>' />
<input type='hidden' name='tag'  value='<?php hecho($tag) ?>' />

Ajouter un site<?php echo $tag?" dans la cat&eacute;gorie $tag":""?>: <br/>

<input type='text' size='50' name='url' />

<input type='submit' value='Suivre' class="a_btn" />
<p class='petit'>Exemple: L'Equipe, Le Monde, Morandini, ...</p>
</form>

<?php if ($allFlux) : ?>
<div class="box">
	<div class="haut">
		<h2>Derni&egrave;res mises &agrave; jour<?php echo $tag?" dans la cat&eacute;gorie $tag":""?></h2>
	</div>
	<div class="cont">
	
	<?php if ($tag) : ?>
		<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir &agrave; la liste des sites</a>
	<?php endif;?>
	<?php 
		$paginator->displayNext("&laquo; Sites mis &agrave; jour plus r&eacute;cemment"); 
		$feedHTML->display($allFlux,$id,$tag);
		$paginator->displayPrevious("Sites mis &agrave; jour avant &raquo;");
	?>
</div>
			<div class="bas"></div>				
		</div>
<?php else: ?>
<div class="box">
	<div class="haut">
	<h2>Suivi des sites</h2>
	</div>
	<div class="cont">
	
	<div class="box_info">
	<p>Vous ne suivez actuellement aucun site.</p>
	<p>Pour suivre un site, inscrivez son nom dans le formulaire ci-dessus.</p>
	</div>
	
	
</div>
<div class="bas"></div>				
</div>


<?php
//De LBI pour ERIC : voici les box info, err, confirm, etc...
?>
<!--
<div class="box">
	<div class="haut"><h2>Messages</h2></div>
	<div class="cont">
	

	<div class="box_info"><p>box_info</p></div>
	<div class="box_error"><p>box_error</p></div>
	<div class="box_alert"><p>box_alert</p></div>
	<div class="box_confirm"><p>box_confirm</p></div>
	<div class="box_focus"><p>box_focus</p></div>			
	<div class="box_code"><p>box_code</p></div>	
	<div class="breadcrumbs"><p>breadcrumbs</p></div>	


	</div>
<div class="bas"></div>				
</div>
-->


<?php endif;?>


</div>

<div id="colonne">
<?php if (! $authentification->getNamedAccount()) : ?>
<div class="box">
	<div class="haut"><h2>Compte anonyme</h2></div>
	<div class="cont">
	
	<p>Vous &ecirc;tes actuellement sur un compte anonyme.</p>
	<p>Adresse de cette page : <a href='http://<?php echo DOMAIN_NAME?>?<?php echo $id?>'>http://<?php echo DOMAIN_NAME?>?id=<?php echo $id?></a></p>
	
	<p class="align_center">
		<a class="a_btn" href="http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>">Cr&eacute;er un compte gratuitement</a>
	</p>
	
	
</div>
<div class="bas"></div>				
</div>
<?php endif;?>

</div><!-- fin contenu -->

<?php 

$pageHTML->bas();




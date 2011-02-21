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

<form action='add-flux.php' method='post'>
<input type='hidden' name='id'  value='<?php hecho($id) ?>' />
<input type='hidden' name='tag'  value='<?php hecho($tag) ?>' />

Ajouter un site<?php echo $tag?" dans la cat&eacute;gorie $tag":""?>: <br/>
<?php if ($lastMessage->getLastMessage()) : ?>
<p>
<?php echo $lastMessage->getLastMessage(); ?>
</p>
<?php endif;?>
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
	
	<p>Vous ne suivez actuellement aucun site.</p>
	
	<p>Pour suivre un site, &eacute;crivez son nom dans le formulaire ci-dessus.
	</p>
</div>
<div class="bas"></div>				
		</div>
<?php endif;?>
<?php if (! $authentification->getNamedAccount()) : ?>
<div class="box">
	<div class="haut">
	<h2>Compte anonyme</h2>
	</div>
	<div class="cont">
	
	<p>Vous êtes actuellement sur un compte anonyme.</p>
	<p>Pour retrouver cette page : <a href='http://<?php echo DOMAIN_NAME?>?<?php echo $id?>'>http://<?php echo DOMAIN_NAME?>?id=<?php echo $id?></a></p>
	<br/>
	<a href='http://<?php echo DOMAIN_NAME?>/create-account.php?id=<?php echo $id ?>'>Cr&eacute;er un compte gratuitement</a></p>
	<br/>
	</p>
</div>
<div class="bas"></div>				
		</div>
<?php endif;?>

<?php 

$pageHTML->bas();




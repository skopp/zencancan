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

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());
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

Ajouter un site<?php echo $tag?" dans la catégorie $tag":""?>: <br/>
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
		<h2>Dernières mises à jour<?php echo $tag?" dans la catégorie $tag":""?></h2>
	</div>
	<div class="cont">
	
	<?php if ($tag) : ?>
		<a href='index.php?id=<?php hecho($id)?>'>« Revenir à la liste des sites</a>
	<?php endif;?>
	<?php 
		$paginator->displayNext("« Sites mis à jour plus récemment"); 
		$feedHTML->display($allFlux,$id,$tag);
		$paginator->displayPrevious("Sites mis à jour avant »");
	?>
</div>
			<div class="bas"></div>				
		</div>
<?php else: ?>
<div class="box">
	<div class="haut">
	<h2>Suivie des sites</h2>
	</div>
	<div class="cont">
	
	<p>Vous ne suivez actuelllement aucun site.</p>
	
	<p>Pour suivre un site, écrivez juste son nom dans le formulaire du dessus.
	</p>
</div>
<div class="bas"></div>				
		</div>
<?php endif;?>
<?php 

$pageHTML->bas();




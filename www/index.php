<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PasswordGenerator.class.php");
require_once("PageHTML.class.php");
require_once("AbonnementSQL.class.php");
require_once("FancyDate.class.php");
require_once("util.php");
require_once("Paginator.class.php");

$recuperateur = new Recuperateur($_GET);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$fancyDate = new FancyDate();

$id = $recuperateur->get('id');
$offset = $recuperateur->getInt('offset',0);
$tag = $recuperateur->get('tag');

if (strlen($id) > 16 ){
	setcookie("id","");
	$id = "";
}

if (isset($_COOKIE['id'])){
	if (! $id ){
		header("Location: index.php?id=".$_COOKIE['id']);
		exit;
	}
	if ($id !=  $_COOKIE['id'] ){
		setcookie("id",$id);
		header("Location: index.php?id=$id");
		exit;
	} 
}

if (! $id ){
	$passwordGenerator = new PasswordGenerator();
	$id = $passwordGenerator->getPassword();
	setcookie("id",$id);
	header("Location: index.php?id=$id");
	exit;
}

$allFlux = $abonnementSQL->get($id,$tag,$offset);
$nbFlux = $abonnementSQL->getNbFlux($id,$tag);

$paginator = new Paginator($nbFlux,AbonnementSQL::NB_DISPLAY,$offset);
$paginator->setLink("index.php?id=$id&tag=$tag");

$pageHTML = new PageHTML($id,$debut);
$pageHTML->haut();
?>

<form action='add-flux.php' method='post'>
<input type='hidden' name='id'  value='<?php hecho($id) ?>' />
Site à suivre: <br/>
<?php if ($lastMessage->getLastMessage()) : ?>
<p>
<?php echo $lastMessage->getLastMessage(); ?>
</p>
<?php endif;?>
<input type='text' size='50' name='url' />
<input type='submit' value='Suivre' />
</form>
<p class='petit'>Exemple: L'Equipe, Le Monde, Morandini, ...</p>



<?php if ($tag) : ?>
<a href='index.php?id=<?php hecho($id)?>'>« Revenir à la liste des sites</a>
<?php endif;?>

<?php if ($allFlux) : ?>
<h2>Dernières mises à jour<?php echo $tag?" dans la catégorie $tag":""?> :</h2>
<?php $paginator->displayNext("« Sites mis à jour plus récemment"); ?>
<table>
<?php foreach($allFlux as $flux) : ?>
	<tr>
		<td class='date'><a name='' title='Dernier passage : <?php echo $fancyDate->get($flux['last_recup'])?>'><?php echo $fancyDate->get($flux['last_maj'])?></a></td>
		<td class='tag'>
		<?php if(! $tag): ?>
			<a href='index.php?id=<?php echo $id?>&tag=<?php echo $flux['tag']?>'><?php echo $flux['tag'] ?></a>
		<?php endif;?>
		</td>
		
		<td class='site'><a href='feed.php?id=<?php echo $id ?>&id_f=<?php hecho($flux['id_f'])?>' title='<?php hecho($flux['title'])?>'><?php hecho(wrap($flux['title'],25,2))?></a></td>
	
		<td class='lien'><a href='<?php hecho($flux['item_link'])?>' target='_blank' title='<?php  hecho(wrap(strip_tags($flux['item_content']),200,1)) ?>'>
		<?php hecho($flux['item_title']) ?></a></td>
		
	</tr>
<?php endforeach;?>
</table>
<?php endif;?>
<?php 
$paginator->displayPrevious("Sites mis à jour avant »");
?>
		<p class='petit'>
			<a href='param.php?id=<?php hecho($id)?>'>Configurer mon compte</a>
		</p>
<?php 

$pageHTML->bas();




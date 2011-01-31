<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PageHTML.class.php");
require_once("FancyDate.class.php");
require_once("util.php");
require_once("AbonnementSQL.class.php");
require_once("FeedParser.class.php");
require_once("FancyDate.class.php");
$fancyDate = new FancyDate();

$recuperateur = new Recuperateur($_GET);

$abonnementSQL = new AbonnementSQL($sqlQuery);

$id = $recuperateur->get('id');
$id_f = $recuperateur->getInt('id_f');

if ( ! $abonnementSQL->isAbonner($id,$id_f)){
	header("Location: index.php?id=$id");
	exit;
}

$info = $abonnementSQL->getInfo($id,$id_f);

$content = file_get_contents(STATIC_PATH."/$id_f");

$feedParser = new FeedParser();
$rssInfo = $feedParser->parseXMLContent($content);


$pageHTML = new PageHTML($id,$debut);
$pageHTML->haut();
?>
<?php if ($info['tag']) : ?>
<a href='index.php?id=<?php hecho($id)?>&tag=<?php hecho($info['tag']) ?>'>« Revenir à la liste des sites de la catégorie <?php hecho($info['tag']) ?></a>

<?php else :?>
<a href='index.php?id=<?php hecho($id)?>'>« Revenir à la liste des sites</a>
<?php endif;?>
<h2>Dernières mises à jour de <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a></h2>
<table>
<?php foreach($rssInfo['item'] as $flux) : ?>
	<tr>
		<td class='date'><a name='' title='Dernier passage : <?php echo $fancyDate->get($flux['pubDate'])?>'><?php echo $fancyDate->get($flux['pubDate'])?></a></td>
		<td class='lien'><a href='<?php hecho($flux['link'])?>' target='_blank' title='<?php  echo wrap(strip_tags($flux['description']),200,1) ?>'><?php echo strip_tags($flux['title']) ?></a><br/>
	</td>
	</tr>
<?php endforeach;?>
</table>
<form method='post' action='aggregate.php'>
	Catégorie : 
	<input type='text' name='tag' value='<?php hecho($info['tag']) ?>' />
	<input type='hidden' name='id' value='<?php echo $id ?>'/>
	<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
	<input class='bouton' type='submit' value='Mettre dans une catégorie'/>
</form>
<form method='post' action='del.php'>
	<input class='bouton' type='submit' value='Supprimer le suivi de ce site'/>
	<input type='hidden' name='id' value='<?php echo $id ?>'/>
	<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
</form>
<?php 
$pageHTML->bas();


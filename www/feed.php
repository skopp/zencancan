<?php
require_once( __DIR__."/../init-web.php");
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



$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount(),$compte->isAdmin($authentification->getId()));

$pageHTML->addRSSURL("Votre flux zencancan","rss.php?id=$id");
if ($info['tag']){
	$pageHTML->addRSSURL("Votre flux zencancan - {$info['tag']}","rss.php?id=$id&tag={$info['tag']}");
}
$pageHTML->addRSSURL($info['title'],$info['url']);

$pageHTML->haut();
?>

<div id="contenu">

	<div class="breadcrumbs">
	<?php if ($info['tag']) : ?>
		<a href='index.php?id=<?php hecho($id)?>&tag=<?php hecho($info['tag']) ?>'>&laquo; Revenir &agrave; la liste des sites de la cat&eacute;gorie <?php hecho($info['tag']) ?></a>
		<?php else :?>
		<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir &agrave; la liste des sites</a>
	<?php endif;?>
	</div>
	
<div class="box">
	<div class="haut">
<h2>Derni&egrave;res mises &agrave; jour de <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a></h2>
	</div>
	<div class="cont">
	<?php if ($lastMessage->getLastMessage()) : ?>
		<p>
		<?php echo $lastMessage->getLastMessage(); ?>
		</p>
	<?php endif;?>

<table>
<?php foreach($rssInfo['item'] as $i => $flux) : ?>
	<tr class="<?php echo $i%2?"":"bgcolor01";?>">
		<td class='date'><?php echo $fancyDate->get($flux['pubDate'])?></td>
		<td class='lien'>
			<a href='read.php?id=<?php hecho($id) ?>&id_f=<?php echo $id_f ?>&item=<?php echo urlencode($flux['id_item'])?>' title='<?php  echo get_link_title($flux['content']?:$flux['description']) ?>'>
				<?php echo strip_tags($flux['title']) ?>
			</a>
			<a href='<?php hecho($flux['link'])?>' target='_blank' title="Ouvrir l'article original">
				&raquo;
			</a>
		<br/>
	</td>
	</tr>
<?php endforeach;?>
</table>
</div>
<div class="bas"></div>				
</div>


</div>

<div id="colonne">

<div class="box">
	<div class="haut">
	</div>
	<div class="cont">
<form method='post' action='aggregate.php'>
	
	<input type='hidden' name='id' value='<?php echo $id ?>'/>
	<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
	<p>
	Cat&eacute;gorie : <input type='text' name='tag' value='<?php hecho($info['tag']) ?>' />
	</p>
	<p><input class='submit' type='submit' value='Mettre dans une cat&eacute;gorie'/>	</p>
</form>
</div>
<div class="bas"></div>				
</div>

<div class="box">
	<div class="haut">
	</div>
	<div class="cont">
<form method='post' action='del.php'>
	<p>
	<input class='submit' type='submit' value='Supprimer le suivi de ce site'/>
	</p>
	<input type='hidden' name='id' value='<?php echo $id ?>'/>
	<input type='hidden' name='id_f' value='<?php echo $id_f ?>'/>
</form>
</div>
<div class="bas"></div>				
</div>


</div>



<?php 
$pageHTML->bas();


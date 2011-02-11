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
$item = $recuperateur->get('item');

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


foreach($rssInfo['item'] as $i => $itemInfo){
	if ($itemInfo['id_item'] == $item){
		$resultItem = $itemInfo;
		break;
	}
}


$pageHTML->haut();
?>

<div class="box">
	<div class="haut">
	<h2><?php hecho($resultItem['title'])?>
	- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
	</h2>
	</div>
	<div class="cont">
		<a href='feed.php?id=<?php hecho($id)?>&id_f=<?php echo $id_f?>'>« Revenir aux articles de  <?php hecho($rssInfo['title']) ?></a>
		
		<p class='align_right'>
		<a href='<?php echo $resultItem['link'] ?>' target='_blanck'>Lire l'article original »</a>
		</p>
		<div class='item_content'>
			<?php echo $resultItem['content']?:$resultItem['description'];?>
		</div>
	</div>
	<div class="bas"></div>				
</div>
<?php 
$pageHTML->bas();

<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");
require_once("FancyDate.class.php");
require_once("util.php");
require_once("AbonnementSQL.class.php");
require_once("FeedParser.class.php");
require_once("FancyDate.class.php");
require_once("HTMLNormalizer.class.php");

$fancyDate = new FancyDate();
$recuperateur = new Recuperateur($_GET);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$htmlNormalizer = new HTMLNormalizer();


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

if (empty($resultItem)){
	$lastMessage->setLastMessage(LastMessage::ERROR,"Cet article n'existe pas ou plus");
	header("Location: feed.php?id=$id&id_f=$id_f");
	exit;
}

$content_html = $resultItem['content']?:$resultItem['description'];
$content_html = $htmlNormalizer->get($content_html,$rssInfo['link']);


$pageHTML->haut();
?>


<div id="contenu">
<div class="breadcrumbs">
	<a href='index.php?id=<?php hecho($id)?>'>&laquo; Revenir à la liste des sites</a>
</div>

<div class="box">
	<div class="haut">
	<h2><?php hecho($resultItem['title'])?>
	- <a href='<?php hecho($rssInfo['link']) ?>'><?php hecho($rssInfo['title']) ?></a>
	</h2>
	</div>
	<div class="cont">

	
		<a href='feed.php?id=<?php hecho($id)?>&id_f=<?php echo $id_f?>'>&laquo; Revenir aux articles de  <?php hecho($rssInfo['title']) ?></a>
		
		<p class='align_right'>
		<a href='<?php echo $resultItem['link'] ?>' target='_blank'>Lire l'article original &raquo;</a>
		</p>
		<div class='item_content'>
			<?php echo $content_html;?>
		</div>
	</div>
	<div class="bas"></div>				
</div>
</div>

<div id="colonne">
<div class="box">
	<div class="haut"><h2><?php hecho($rssInfo['title']) ?></h2></div>
	<div class="cont">
		<ul class="ul_lien">
			<?php foreach($rssInfo['item'] as $i => $itemInfo) : ?>
				<li>
					<?php echo $fancyDate->get($itemInfo['pubDate'])?>
					<a href='read.php?id=<?php hecho($id)?>&id_f=<?php echo $id_f?>&item=<?php echo urlencode($itemInfo['id_item'])?>'  title='<?php  echo get_link_title($itemInfo['content']?:$itemInfo['description']) ?>'>
						<?php echo strip_tags($itemInfo['title']) ?>
					</a>
				</li>
	
			<?php endforeach; ?>
		</ul>
	</div>
<div class="bas"></div>				
</div>
</div>

<?php 
$pageHTML->bas();


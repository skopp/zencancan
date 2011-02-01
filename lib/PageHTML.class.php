<?php
require_once("util.php");


class PageHTML {
	
	private $debut;
	private $id;
	private $namedAccount;
	private $rss;
	
	public function __construct($id,$debut,$namedAccount = false ){
		$this->debut = $debut;
		$this->id = $id;
		$this->namedAccount = $namedAccount;
		$this->rss = array();
	}
	
	
	public function addRSSURL($title,$url){
		$this->rss[] = array('title' => $title,'url' => $url);
	}
	
	public function haut(){
		header("Content-type: text/html; charset=UTF-8");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>La gestion simple du suivi de site - zenCancan </title>
		<meta name="description" content='La gestion simple du suivi de site' />
		
		<link rel="stylesheet" type="text/css" href="zencancan.css" media="screen" />
		<?php foreach ($this->rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo $feed['title'] ?>" href="<?php echo $feed['url'] ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
		<div id='header'>
			<h1><a href='index.php?id=<?php echo $this->id ?>'>zenCancan</a></h1>
		</div>
		
		<div id='content'>
			<?php if (! $this->namedAccount && $this->id) : ?>
				<p>
				Votre identifiant : <a href='param.php?id=<?php hecho($this->id)?>'><?php hecho($this->id) ?></a>
				</p>
			<?php endif;?>
		<?php 		
	}
	
	public function bas($debut = false){
		?>
		</div>
		<div id='footer'>
			<p class='temps'> 
			Page générée par zenCancan en <?php echo round((microtime(true) - $this->debut) * 10000) / 10 ?>ms
			</p>		
		</div>
	</body>
</html>	
<?php 
	}
}
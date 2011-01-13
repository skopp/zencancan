<?php
class PageHTML {
	
	private $debut;
	
	public function __construct($debut){
		$this->debut = $debut;
	}
	
	public function haut($id){
		header("Content-type: text/html; charset=UTF-8");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>La gestion simple du suivie de commentaire - zenCancan </title>
		<meta name="description" content='La gestion simple du suivie de commentaire' />
		
		<link rel="stylesheet" type="text/css" href="zencancan.css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="zenCancan - votre flux" href="rss.php?id=<?php echo $id?>" />
		
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
		<div id='header'>
			<h1><a href='index.php'>zenCancan</a></h1>
		</div>
		
		<div id='content'>
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
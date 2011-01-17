<?php
class PageHTML {
	
	private $debut;
	private $id;
	
	public function __construct($id,$debut){
		$this->debut = $debut;
		$this->id = $id;
	}
	
	public function haut(){
		header("Content-type: text/html; charset=UTF-8");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>La gestion simple du suivie de site - zAgregator </title>
		<meta name="description" content='La gestion simple du suivie de commentaire' />
		
		<link rel="stylesheet" type="text/css" href="zencancan.css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="zenCancan - votre flux" href="rss.php?id=<?php echo $this->id?>" />
		
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
		<div id='header'>
			<h1><a href='index.php?id=<?php echo $this->id ?>'>zAgregator</a></h1>
		</div>
		
		<div id='content'>
			
			<p>
			Votre identifiant : <a href='param.php?id=<?php hecho($this->id)?>'><?php hecho($this->id) ?></a>
			</p>
		<?php 		
	}
	
	public function bas($debut = false){
		?>
		</div>
		<div id='footer'>
			<p class='temps'> 
			Page générée par zAgregator en <?php echo round((microtime(true) - $this->debut) * 10000) / 10 ?>ms
			</p>		
		</div>
	</body>
</html>	
<?php 
	}
}
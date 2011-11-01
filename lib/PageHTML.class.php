<?php
require_once("util.php");


class PageHTML {
	
	private $debut;
	private $id;
	private $namedAccount;
	private $rss;
	private $isAdmin;
	
	public function __construct($id,$debut,$namedAccount = false, $isAdmin = false ){
		$this->debut = $debut;
		$this->id = $id;
		$this->namedAccount = $namedAccount;
		$this->rss = array();
		$this->isAdmin = $isAdmin;
	}
	
	
	public function addRSSURL($title,$url){
		$this->rss[] = array('title' => $title,'url' => $url);
	}
	
	public function haut(){
		header("Content-type: text/html; charset=UTF-8");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='La gestion simple du suivi de site' />
		
		<link rel="stylesheet" type="text/css" href="img/commun.css?i=1" media="screen" />
		<?php foreach ($this->rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo $feed['title'] ?>" href="<?php echo $feed['url'] ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
	<div id="container">
	
		<div id="header" class="wrap">
			<div id="logo">
				<a href="index.php?id=<?php echo $this->id ?>"><img src="img/commun/logo.png" alt="" /></a>
			</div>
			<div id="menu_login">
			<?php if (! $this->namedAccount && $this->id) : ?>
				<a href='login.php?id=<?php hecho($this->id) ?>'>Connexion</a> |
			<?php else:?>
			Bienvenue <span class='name'><?php echo $this->namedAccount ?></span> |
			<?php endif;?>
			<a href='param.php?id=<?php hecho($this->id)?>'>Param&egrave;tres</a> |
			<a href='logout.php'>D&eacute;connexion</a> | 
			<a href='site.php'>Aide</a> 
			<?php if ($this->isAdmin) : ?>
				| <a href='admin.php'>Admin</a> 
			<?php endif;?>
			
			</div>
		</div>
		
		<div id="main" class="wrap">
		
		


		<?php
	}
	public function bas($debut = false){
		global $revision_number;
		?>
		
		</div><!-- fin main -->
		
			<div class="clearfooter"></div>
		</div><!-- fin container -->
		
		
		<div id="footer">
			<div class="wrap">
			<p class="align_center">
			Page g&eacute;n&eacute;r&eacute;e par zenCancan r&eacute;vision <?php echo $revision_number ?> en <?php echo round((microtime(true) - $this->debut) * 10000) / 10 ?>ms
			- <a href='legal.php'>Mentions l&eacute;gales</a>
			</p>
			</div>
		</div><!-- fin footer -->
		
		
	</body>
</html>	
<?php 
	}
	
	public function menu(){ ?>
	<div id="colonne">
	
	
		<div class="box">
			<div class="haut"><h2>Utilisateur</h2></div>
			<div class="cont">
				<ul class="ul_lien">
				<li><a href="http://<?php echo DOMAIN_NAME ?>/create-account.php">Cr&eacute;er un compte</a></li>
				<li><a href="http://<?php echo DOMAIN_NAME ?>/index.php">Tester sur un compte anonyme</a></li>
				<li><a href="http://<?php echo DOMAIN_NAME ?>/login.php">Se connecter</a></li>
				<li><a href="contact.php">Nous contacter</a></li>
				</ul>
			
			</div>
			<div class="bas"></div>				
		</div>
		
		<div class="box">
			<div class="haut"><h2>D&eacute;veloppeur</h2></div>
			<div class="cont">
			
			<ul class="ul_lien">
			<li><a href="http://soft.zenprog.com/zenCancan.tgz">T&eacute;lecharger</a></li>
			<li><a href="http://source.zenprog.com/zencancan">Voir le code source</a></li>
			<li><a href="site.php#licence">Licence</a></li>
			</ul>
			</div>
			<div class="bas"></div>				
		</div>
		
		
	</div><!-- fin colonne -->
	<?php 
	
	}
	
}
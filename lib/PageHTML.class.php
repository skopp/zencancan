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
		
		<link rel="stylesheet" type="text/css" href="img/commun.css" media="screen" />
		<?php foreach ($this->rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo $feed['title'] ?>" href="<?php echo $feed['url'] ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
	<div id="container">
	
		<div id='header'  class="wrap">
			<div id="logo">
				<a href="index.php?id=<?php echo $this->id ?>"><img src="img/commun/logo.png" alt="" /></a>
			</div>
			<div id="menu_login">
			<?php if (! $this->namedAccount && $this->id) : ?>
				Votre identifiant :
				 <a href='param.php?id=<?php hecho($this->id)?>'><?php hecho($this->id) ?></a>		
			(<a href='login.php?id=<?php hecho($this->id) ?>'>Connexion</a>)
			|
			<?php else:?>
			Bienvenue <span class='name'><?php echo $this->namedAccount ?></span> |
			<?php endif;?>
			<a href='param.php?id=<?php hecho($this->id)?>'>Paramètres</a> |
			<a href='logout.php'>Déconnexion</a> | 
			<a href='site.php'>Aide</a> 
			
			</div>
		</div>
		
		<div id="main" class="wrap">

		<?php 		
	}
	
	public function bas($debut = false){
		?>
		
		</div><!-- fin main -->
		
		<div id="footer">
			<div class="wrap">
			<p class='temps'>Page générée par zenCancan en <?php echo round((microtime(true) - $this->debut) * 10000) / 10 ?>ms
			</p>
			</div>
		</div><!-- fin footer -->
		</div><!-- fin container -->
	</body>
</html>	
<?php 
	}
	
	public function menu(){ ?>
	<div id="colonne">
	
	
		<div class="box">
			<div class="haut"><h2>Utilisateur</h2></div>
			<div class="cont">
			
			
			<p><a class='menu_link' href='create-account.php'>Créer un compte</a></p>
			<p><a class='menu_link' href='index.php'>Tester sur un compte anonyme</a></p>
			<p><a class='menu_link' href='login.php'>Se connecter</a></p>
			<p><a class='menu_link' href='contact.php'>Nous contacter</a></p>
			</div>
			<div class="bas"></div>				
		</div>
		
		<div class="box">
			<div class="haut"><h2>Développeur</h2></div>
			<div class="cont">
			<p><a class='menu_link' href='http://soft.zenprog.com/zenCancan.tgz'>Télecharger</a></p>
			<p><a class='menu_link' href='http://source.zenprog.com/zencancan'>Voir le code source</a></p>
			<p><a class='menu_link' href='site.php#licence'>Licence</a></p>
			</div>
			<div class="bas"></div>				
		</div>
		
		
	</div><!-- fin colonne -->
	<?php 
	
	}
	
}
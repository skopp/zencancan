<?php header("Content-type: text/html; charset=UTF-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='La gestion simple du suivi de site' />
		
		<link rel="stylesheet" type="text/css" href="<?php $this->Path->echoRessourcePath("/img/commun.css?i=1") ?>" media="screen" />
		<?php foreach ($rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php hecho($feed['title']) ?>" href="<?php hecho($feed['url']) ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="<?php $this->Path->echoRessourcePath("/favicon.ico") ?>" type="image/x-icon" />
	</head>
	<body>
	<div id="container">
	
		<div id="header">
			
				<div id="logo">
					<a href="<?php  $this->Path->path()?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/logo.png") ?>" alt="" /></a>
				</div>
				
				<div id="menu_login">
					
					<div class="item_mur_site">
						<?php if ($id_u) : ?>
							<a href='<?php $this->Path->path("/Mur/index")?>'>Mon mur</a>|
							<a class='actif' href='<?php $this->Path->path("/Feed/list")?>'>Mes sites</a>
						<?php endif;?>
					</div>
					<div class="item_login">
						<?php if ($id_u) : ?>
							Bienvenue <span class='nom_user'><?php echo $namedAccount ?></span> |
							<a href='<?php $this->Path->path("/Param/index")?>'>Param&egrave;tres</a> |
							<a href='<?php $this->Path->path("/Connexion/doLogout")?>'>D&eacute;connexion</a> | 
							<a href='<?php $this->Path->path("/Aide/index")?>'>Aide</a> 
								<?php if ($isAdmin) : ?>
									| <a href='<?php $this->Path->path("/Admin/flux")?>'>Admin</a> 
								<?php endif;?>
						<?php else : ?>
							<a  href='<?php echo $this->Path->getPathWithUsername();?>'>Accueil</a>
							<a  href='<?php $this->Path->path('/Connexion/login');?>'>Se connecter</a>
							<a href='<?php echo $this->Path->getPathWithUsername("",'/Account/create');?>'>Cr&eacute;er un compte</a>
						<?php endif;?>
					</div>
				</div>
			
			
		</div>
		
		<div id="box_add_flux">
			
				<?php if ($this->Connexion->getId() && isset($add_site)) : ?>
				
				<form  action='<?php $this->Path->path() ?>' method='post'>
				<?php $this->Connexion->displayTokenField(); ?>
				<input type='hidden' name='path_info' value='/Feed/doAdd' />
				
				
				Ajouter un site: <br/>
				
				<input type='text' size='50' name='url' />
				
				<input type='submit' value='Suivre' class="a_btn" />
				<p>Exemple: L'Equipe, Le Monde, Morandini, ...</p>
				</form>
				<?php else : ?>
				<br/><br/><br/>
				<?php endif;?>

		</div>
		
		
		<div id="main">
			
			<?php $this->render($template_milieu);?>
			
		</div><!-- fin main -->
		
			<div class="clearfooter"></div>
		</div><!-- fin container -->
		
		
		<div id="footer">
			
			<p class="align_right">
			Page g&eacute;n&eacute;r&eacute;e par zenCancan r&eacute;vision <?php echo $revision_number ?> en <?php echo round((microtime(true) - $debut) * 10000) / 10 ?>ms
			- <a href='<?php $this->Path->path("/Param/legal") ?>'>Mentions l&eacute;gales</a>
			</p>
			
		</div><!-- fin footer -->
		
		
	</body>
</html>	
		
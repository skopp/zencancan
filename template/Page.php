<?php header("Content-type: text/html; charset=UTF-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='La gestion simple du suivi de site' />	
		<link type="text/css" href="<?php $this->Path->echoRessourcePath("/img/style.css?i=2") ?>" rel="stylesheet" media="screen" />
		<link type="text/css" href="<?php $this->Path->echoRessourcePath("/img/effet.css?i=1") ?>" rel="stylesheet" media="screen" />
		<?php foreach ($rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php hecho($feed['title']) ?>" href="<?php hecho($feed['url']) ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="<?php $this->Path->echoRessourcePath("/favicon.ico") ?>" type="image/x-icon" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php $this->Path->echoRessourcePath("/js/code.js") ?>"></script>
		
	</head>
	<body>
	<div id="container">
		<a name="top" id="top"></a>
		<div id="header">
			<div class="wrap">
				<div id="logo">
					<a href="<?php  $this->Path->path()?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/logo.png") ?>" alt="" /></a>
				</div>
				
				<div id="addflux">
					<?php if ($this->Connexion->getId() && isset($add_site)) : ?>
						<form  action='<?php $this->Path->path() ?>' method='post'>
						<?php $this->Connexion->displayTokenField(); ?>
						<input type='hidden' name='path_info' value='/Feed/doAdd' />
						<input name='url' class="recherche tooltip" title="Ajouter un site<br>Exemple : Morandini, lemonde, etc..." type="text" value="Ajouter un site" 
							onclick="this.value='';"
							onblur="if (this.value=='') this.value='Ajouter un site';" 
						/>
						<input class="btn_go" type="submit" value="GO" />
						</form>
					<?php endif;?>
				</div>
				
				<div id="menu">
				<?php if ($id_u) : ?>
					<ul>
						<li><a  href='<?php $this->Path->path("/Feed/list")?>'>Mes sites</a></li>
						<li><a href='<?php $this->Path->path("/Param/index")?>'>Param&egrave;tres</a></li>
						<li><a href='<?php $this->Path->path("/Connexion/doLogout")?>'>D&eacute;connexion</a></li> 
						<?php if ($isAdmin) : ?>
							<li><a href='<?php $this->Path->path("/Admin/flux")?>'>Admin</a></li> 
						<?php endif;?>
					</ul>

				<?php else: ?>
					<ul>
					<li><a href='<?php $this->Path->path();?>'>Accueil</a></li>
					<li><a href='<?php $this->Path->path('/Connexion/login');?>'>Se connecter</a></li>
					<li><a href='<?php $this->Path->path('/Account/create');?>'>Cr&eacute;er un compte</a></li>
					</ul>
				<?php endif;?>				
				</div>
			</div>
		</div><!-- header -->

		
		<div id="global_main" class="wrap">
			<div id="main">
				<?php $this->render($template_milieu);?>
			</div><!-- fin main -->
			
			
			<div id="footer">
				<p class="align_right">
					Page g&eacute;n&eacute;r&eacute;e par zenCancan en <?php echo round((microtime(true) - $debut) * 10000) / 10 ?>ms
					| <a href="<?php $this->Path->path("/Param/legal") ?>" rel="nofollow">Mentions l&eacute;gales</a>
					| R&eacute;alisation : <a href="http://www.sigmalis.com" title="Cr&eacute;ation de site web à Lyon">Sigmalis</a>
				</p>
			</div><!-- fin footer -->
		</div><!-- fin global_main -->
	
	</div><!-- fin container -->
</body>
</html>

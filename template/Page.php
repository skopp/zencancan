<?php header("Content-type: text/html; charset=UTF-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='La gestion simple du suivi de site' />	
		<link type="text/css" href="<?php $this->Path->echoRessourcePath("/img/style.css?i=1") ?>" rel="stylesheet" media="screen" />
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
						<li><a class='actif' href='<?php $this->Path->path("/Feed/list")?>'>Mes sites</a></li>
						<li><a href='<?php $this->Path->path("/Mur/index")?>'>Mon mur</a></li>
						<!-- <li><a href="<?php $this->Path->path("/Feed/new")?>">Nouveau site</a></li> -->
						<li><a href="#" class="option" id="option_btn">Options</a></li>
						<?php if ($isAdmin) : ?>
							<li><a href='<?php $this->Path->path("/Admin/flux")?>'>Admin</a></li> 
						<?php endif;?>
					</ul>
					
					<div id="option_menu">
						<ul>
						<li><a href='<?php $this->Path->path("/Param/index")?>'>Param&egrave;tres</a><hr/></li>
						<li><a href="<?php $this->Path->path("/Param/import")?>">Importer mes flux</a><hr/></li>
						<li><a href='<?php $this->Path->path("/Aide/index")?>'>Aide</a><hr/></li>
						<li><a href='<?php $this->Path->path("/Connexion/doLogout")?>'>D&eacute;connexion</a></li> 
						</ul>
					</div>
				</div>
				<?php else: ?>
					<ul>
					<li><a href='<?php echo $this->Path->getPathWithUsername();?>'>Accueil</a></li>
					<li><a href='<?php $this->Path->path('/Connexion/login');?>'>Se connecter</a></li>
					<li><a href='<?php echo $this->Path->getPathWithUsername("",'/Account/create');?>'>Cr&eacute;er un compte</a></li>
					</ul>
				<?php endif;?>				
			</div>
		</div><!-- header -->

		
		<div id="global_main" class="wrap">
			<div id="main">
				<?php $this->render($template_milieu);?>
			</div><!-- fin main -->
			
			
			
			
			<div id="footer">
				<p class="align_right">
					Page g&eacute;n&eacute;r&eacute;e par zenCancan r&eacute;vision <?php echo $revision_number ?> en <?php echo round((microtime(true) - $debut) * 10000) / 10 ?>ms
					- <a href='<?php $this->Path->path("/Param/legal") ?>'>Mentions l&eacute;gales
					</a>
				</p>
			</div><!-- fin footer -->
		</div><!-- fin global_main -->
	
	</div><!-- fin container -->
</body>
</html>

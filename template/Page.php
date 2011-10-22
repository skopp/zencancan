<?php header("Content-type: text/html; charset=UTF-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='La gestion simple du suivi de site' />
		
		<link rel="stylesheet" type="text/css" href="img/commun.css" media="screen" />
		<?php foreach ($rss as $feed) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo $feed['title'] ?>" href="<?php echo $feed['url'] ?>" />
		<?php endforeach;?>
		<link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
	</head>
	<body>
	<div id="container">
	
		<div id="header" class="wrap">
			<div id="logo">
				<a href="index.php?id=<?php echo $id ?>"><img src="img/commun/logo.png" alt="" /></a>
			</div>
			<div id="menu_login">
			<?php if (! $namedAccount && $id) : ?>
				<a href='login.php?id=<?php hecho($id) ?>'>Connexion</a> |
			<?php else:?>
			Bienvenue <span class='name'><?php echo $namedAccount ?></span> |
			<?php endif;?>
			<a href='param.php?id=<?php hecho($id)?>'>Param&egrave;tres</a> |
			<a href='logout.php'>D&eacute;connexion</a> | 
			<a href='site.php'>Aide</a> 
			<?php if ($isAdmin) : ?>
				| <a href='admin.php'>Admin</a> 
			<?php endif;?>
			
			</div>
		</div>
		
		<div id="main" class="wrap">
			<?php $this->render($template_milieu);?>
				
		</div><!-- fin main -->
		
			<div class="clearfooter"></div>
		</div><!-- fin container -->
		
		
		<div id="footer">
			<div class="wrap">
			<p class="align_center">
			Page g&eacute;n&eacute;r&eacute;e par zenCancan révision <?php echo $revision_number ?> en <?php echo round((microtime(true) - $debut) * 10000) / 10 ?>ms
			- <a href='legal.php'>Mentions légales</a>
			</p>
			</div>
		</div><!-- fin footer -->
		
		
	</body>
</html>	
		
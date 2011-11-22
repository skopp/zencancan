<?php header("Content-type: text/html; charset=ISO-8859-1");?> 
<?php session_start(); ?>
<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
<title>TODO</title>
<meta name="description" content="TODO" />
<meta name="keywords" content="TODO" /> 
<meta name="language" content="fr" />
<meta name="author" content="Sigmalis" />
<meta name="robots" content="index,follow" />

<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-15"/>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


<script type="text/javascript" src="js/code.js"></script>

<link type="text/css" href="img/style.css?c=0" rel="stylesheet" media="screen" />
<link type="text/css" href="img/effet.css?c=0" rel="stylesheet" media="screen" />




<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>

<body>
	<div id="container">
		
		<div id="header">
			<div class="wrap">
				<div id="logo">
					<a href="index.php"><img src="img/commun/logo.png" alt="Accueil" /></a>
				</div>
				
				<div id="addflux">
					<form action="#">
					<input class="recherche" type="text" value="Ajouter un site" 
						onclick="this.value='';"
						onblur="if (this.value=='') this.value='Ajouter un site';" 
					/>
					<input class="btn_go" type="submit" value="GO" />
					</form>
				</div>
				
				<div id="menu">
					<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="#">Mon mur</a></li>
					<li><a href="mes_sites.php">Mes sites</a></li>
					<li><a href="#">Nouveau site</a></li>
					<li><a href="#" class="option" id="option_btn">Options</a></li>
					</ul>
					
					<div id="option_menu">
						<ul>
						<li><a href="#">Paramètre de mon compte</a><hr/></li>
						<li><a href="#">Importer mes flux</a><hr/></li>
						<li><a href="#">Aide</a><hr/></li>
						<li><a href="#">Déconnexion</a></li>
						</ul>
					</div>
				</div>
				
				

				
				
			</div>
		</div><!-- header -->

		<div id="global_main" class="wrap">
		
		<div id="main">
			<div id="colonne">
				<?php include('_colonne.php'); ?>
				
				
			</div>
			
			<div id="contenu">
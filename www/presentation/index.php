<?php header("Content-type: text/html; charset=ISO-8859-1");?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<?php
$title = "title";
$description = "";
?>

<head>
<title><?php echo $title ?></title>
<meta name="description" content="<?php echo $description ?>" />

<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-15"/>

<link type="text/css" href="img/style.css?c=1" rel="stylesheet" media="screen" />


<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
	<div id="container">
		
		<div id="header">
			<div class="wrap">
				<div id="logo">
					<a href="#"><img src="img/logo.png" alt="Accueil ZenCancan" /></a>
				</div>
				<div id="menu">
					<ul>
						<li><a href="#">Connexion</a></li>
						<li><a href="#">Créer un compte</a></li>
					</ul>
				</div>
			</div>
		</div><!-- header -->

		<div id="header2">
			<div class="wrap">
				
				<div class="col">
					<div class="capture">
					<img src="img/capture.jpg" alt="" height="400" />
					</div>
					
					<div class="texte">
					<h1>ZenCancan</h1>
					<h2>Suivez facilement les sites que vous aimez.</h2>
					<p>ZenCancan est une application web qui vous permet de suivre facilement les nouvelles publications d'un blog ou d'un site web</p>
					
					<a href="" class="big_btn">Créer un<br/>compte</a>
					<a href="" class="big_btn">Connexion à<br/>votre compte</a>
					
					
					<div class="texte2 clear">
						<h2>Une nouvelle façon de lire vos flux RSS</h2>
						<ul>
						<li>zenCancan affiche seulement le dernier article de chaque site que vous suivez.</li>
						<li>zenCancan ne vous indiqueras jamais que vous n'avez pas lu un article ! C'est la partie zen de l'application.</li>
						</ul>
					</div>
					</div>
				</div>
				

				
				
			</div>
		</div>
		

		
	
		<div id="contenu">
			<div class="wrap">
			
			<div class="focus">
			<p>Si vous utilisez souvent d'autres lecteurs de flux, vous avez remarqué que, tous comme pour le mail, il vous oblige à tous lire !</p>
			<p>Vous être constamment sous le stress d'avoir tous vos flux à 0 nouvelles non lu !</p>
			<p>La lecture de flux devant resté amusante et zen, vous ne verrez jamais sur zencancan l'outils vous dire que vous n'avez pas fait tel ou tel chose !</p>
			</div>

			
			<div class="bloc">
				<h3>Support</h3>
				<p>Malgré tous le soin apporté au développement, il reste et il restera sans doute tous le temps des problèmes.</p>
				<br/>
				<p>Afin de nous aidez à améliorer notre produit, vous pouvez à tous moment nous contacter. (sauf si vous souhaitez voir intégrer une fonction de non-lu !)</p>
			</div>
			
			
			<div class="bloc">
				<h3>Libre et gratuit</h3>
				<p>Bien que nous nous engageons à ne pas utiliser vos données (par exemple, nous ne vous demandons pas de nous fournir un email) vous n'êtes pas obligé de nous faire confiance sur ce point.</p>
				<p>zenCancan est un logiciel libre, c'est à dire que vous pouvez télécharger son code source et l'installer sur votre machine, sur votre serveur, où bon vous semblera.</p>
			</div>
			
		
			
			</div>
		</div><!-- contenu -->

		<div id="footer">
			<div class="wrap">
				
				<div class="bloc">
				<h3>Contactez-nous</h3>
				<p>Si vous trouver que ce logiciel est original et bien concu, et si vous souhaitez développer une application web, vous pouvez nous contacter.</p>
				</div>
			
				<div class="bottom_info">
					<a href="#">mentions légales</a>&nbsp;|&nbsp;&copy;Sigmalis <?php echo  date('Y') ?>
				</div>
			</div>
		</div><!-- footer -->




	</div><!-- container -->
</body>
</html>
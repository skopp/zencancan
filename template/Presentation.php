<?php header("Content-type: text/html; charset=UTF-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>zenCancan : La gestion simple du suivi de site</title>
		<meta name="description" content='zencancan est un lecteur de flux RSS en ligne' />
		
		<link rel="stylesheet" type="text/css" href="<?php $this->Path->echoRessourcePath("/img/commun.css?i=1") ?>" media="screen" />
		<link rel="Shortcut Icon" href="<?php $this->Path->echoRessourcePath("favicon.ico") ?>" type="image/x-icon" />
	</head>
	<body>
	<div id="container">
	
		<div id="header">
				<div id="logo">
					<a href="<?php $this->Path->path()?>"><img src="<?php $this->Path->echoRessourcePath("/img/commun/logo.png") ?>" alt="" /></a>
				</div>
		</div>
		
			<div id="box_add_flux">
			<div class="wrap">
				
				&nbsp;<br/><br/>
				<?php if ($this->Authentification->getId()) : ?>
					<a href='<?php $this->Path->path();?>'>Retourner à mon compte</a>
				<?php else : ?>
					<a href='<?php $this->Path->path('/Connexion/login');?>'>Se connecter</a>
					<a href='<?php $this->Path->path('/Account/create');?>'>Créer un compte</a>
				<?php endif;?>
				<br/>
				
			

			</div>
		</div>
		
		<div id="main">
			
<div id="contenu">
	<?php $this->LastMessage->display()?>
	
		<div class="box">
			<div class="haut"><h2>Bienvenue sur zenCancan</h2></div>
			<div class="cont">
			<p>
			zenCancan est une application web enti&egrave;rement <b>gratuite</b> 
			qui permet de suivre <b>facilement</b> l'&eacute;volution des 
			sites web.
			</p>
			
			</div>
			<div class="bas"></div>				
		</div>
		
		<div class="box">
			<div class="haut"><h2>Description</h2></div>
			<div class="cont">
			<p>Avec zenCancan, vous saisissez le nom d'un site web (par exemple :<a href='http://www.lemonde.fr/'>Le Monde</a>)
			et automatiquement, chaque fois que la page du <em>Monde</em> changera, zenCancan 
			vous l'indiquera.
			</p>
			<br/>
			
			<p>zenCancan a &eacute;t&eacute; initialement cr&eacute;&eacute; pour suivre les flux de commentaires
			 des billets de blog afin de ne pas polluer les lecteurs de flux par de nombreux petits flux.</p>
<br/>
<p>zenCancan sert aussi &agrave; suivre des gros sites d'actualit&eacute; 
ou des blogs mis
&agrave; jour tr&egrave;s fr&eacute;quemment comme par exemple <a href='http://www.presse-citron.net'>Presse Citron</a>.</p>
<br/>
<p>zenCancan est aussi une tentative pour que les personnes
 qui ne savent pas ce qu'est un flux RSS 
ou une URL puissent suivre simplement des sites web en indiquant juste leur nom.</p>
			</div>
			<div class="bas"></div>				
		</div>		
		
		<div class="box">
			<div class="haut"><h2>Fonctionnalit&eacute;s</h2></div>
			<div class="cont">
				<b>zenCancan</b> offre les fonctionnalit&eacute;s suivantes :
				<br/>	<br/>
				<table>
				
<tr  class="bgcolor01"><td>Inscription automatique et anonyme </td></tr>
<tr  class=""><td>Inscription avec une URL nomm&eacute;e (eric.zencancan.com) </td></tr>
<tr  class="bgcolor01"><td>Protection par mot de passe </td></tr>
<tr><td>Ajout d'un flux RSS via : 
<ul>
<li>l'URL du flux,</li>
 <li>l'URL d'une page HTML disposant d'une alternative RSS,</li>
<li>un mot-cl&eacute; dont
la recherche via <a href='http://www.google.com'>Google</a> 
va afficher une page HTML disposant d'une alternative RSS</li></ul>
</td></tr>
<tr  class="bgcolor01"> <td>Liste des derniers articles de l'ensemble des flux
 tri&eacute;s par date </td></tr>
<tr><td>Aggr&eacute;gation de tous les flux dans un flux RSS unique </td></tr>
<tr  class="bgcolor01"><td>Liste de tous les articles pr&eacute;sents sur le flux 
pour un flux donn&eacute; </td></tr>
<tr><td>Suppresion de flux </td></tr>
<tr  class="bgcolor01"><td>Regroupement des flux via un mot-cl&eacute; (cat&eacute;gorie)</td></tr>
<tr><td>Import/export des flux en OPML </td></tr>
<tr  class="bgcolor01"><td>Lecture de l'article directement dans le logiciel</td></tr>

			</table>
			</div>
			<div class="bas"></div>				
		</div>		
		
		<div class="box">
			<div class="haut"><h2>Licence</h2></div>
			<div class="cont">
			<a name='licence'></a>
			<p>zenCancan est un <a href='http://fr.wikipedia.org/wiki/Logiciel_libre'>logiciel libre</a>  diffus&eacute; sous les termes de la licence zen :</p>
			<blockquote>
			&copy;Sigmalis 2011 - <a href='http://www.sigmalis.com'>Sigmalis</a> vous autorise &agrave; utiliser, &eacute;tudier, copier, modifier et diffuser le logiciel zenCancan 
			sans aucune restriction, ni aucune obligation.
			</blockquote>
			
			</div>
			<div class="bas"></div>				
		</div>		

	</div><!-- fin contenu -->
			
			
		</div><!-- fin main -->
		
			<div class="clearfooter"></div>
		</div><!-- fin container -->
		
		
		<div id="footer">
			
			<p class="align_right">
			Page g&eacute;n&eacute;r&eacute;e par zenCancan en <?php echo round((microtime(true) - $debut) * 10000) / 10 ?>ms
			- <a href='<?php $this->Path->path("/Param/legal") ?>'>Mentions l&eacute;gales</a>
			</p>
			
		</div><!-- fin footer -->
		
		
	</body>
</html>	
		
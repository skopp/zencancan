<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");


$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());


$pageHTML->haut();
$pageHTML->menu();

?>
	
	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Bienvenue sur zenCancan</h2></div>
			<div class="cont">
			<p>
			zenCancan est une application web entièrement <b>gratuite</b> 
			qui permet de suivre <b>facilement</b> l'évolution des 
			sites web.
			</p>
			
			</div>
			<div class="bas"></div>				
		</div>
		
		<div class="box">
			<div class="haut"><h2>Description</h2></div>
			<div class="cont">
			<p>Avec zenCancan, vous saississez le nom d'un site web (par exemple :<a href='http://www.lemonde.fr/'>Le Monde</a>)
			et automatiquement, chaque fois que la page du <em>Monde</em> changera, zenCancan 
			vous l'indiquera.
			</p>
			<br/>
			
			<p>zenCancan a été initialement créer pour suivre les flux de commentaires
			 des billets de blog afin de ne pas polluer les lecteurs de flux par de nombreux petits flux.</p>
<br/>
<p>zenCancan sert aussi à suivre des gros sites d'actualité 
ou des blogs mis
à jour très fréquemment comme par exemple <a href='http://www.presse-citron.net'>Presse Citron</a>.</p>
<br/>
<p>zenCancan est aussi une tentative pour que les personnes
 qui ne savent pas ce qu'est un flux RSS 
ou une URL puissent suivre simplement des sites web en indiquant juste leur nom.</p>
			</div>
			<div class="bas"></div>				
		</div>		
		
		<div class="box">
			<div class="haut"><h2>Fonctionnalités</h2></div>
			<div class="cont">
				<b>zenCancan</b> offre les fonctionnalités suivantes :
				<br/>	<br/>
				<table>
				
<tr  class="bgcolor01"><td>Inscription automatique et anonyme </td></tr>
<tr  class=""><td>Inscription avec une URL nommée (eric.zencancan.com) </td></tr>
<tr  class="bgcolor01"><td>Protection par mot de passe </td></tr>
<tr><td>Ajout d'un flux RSS via : 
<ul>
<li>l'URL du flux,</li>
 <li>l'URL d'une page HTML disposant d'une alternative RSS,</li>
<li>un mot-clé dont
la recherche via <a href='http://www.google.com'>Google</a> 
va afficher une page HTML disposant d'une alternative RSS</li></ul>
</td></tr>
<tr  class="bgcolor01"> <td>Liste des derniers articles de l'ensemble des flux
 trié par date </td></tr>
<tr><td>Aggrégation de tous les flux dans un flux RSS unique </td></tr>
<tr  class="bgcolor01"><td>Liste de tous les items présent sur le flux 
pour un flux données </td></tr>
<tr><td>Suppresion de flux </td></tr>
<tr  class="bgcolor01"><td>Regroupement des flux via un mot-clé (catégorie)</td></tr>
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
			<p>zenCancan est un <a href='http://fr.wikipedia.org/wiki/Logiciel_libre'>logiciel libre</a>  diffusé sous les termes de la licence zen :</p>
			<blockquote>
			©Sigmalis 2011 - <a href='http://www.sigmalis.com'>Sigmalis</a> vous autorise à utiliser, étudier, copier, modifier et diffuser le logiciel zenCancan 
			sans aucune restriction, ni aucune obligation.
			</blockquote>
			
			</div>
			<div class="bas"></div>				
		</div>		

	</div><!-- fin contenu -->
	

<?php 
$pageHTML->bas();




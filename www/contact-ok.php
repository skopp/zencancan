<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());


$pageHTML->haut();
$pageHTML->menu();
?>
	
	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Contact</h2></div>
			<div class="cont">
			<p>Votre message a &eacute;t&eacute; envoy&eacute;</p>
		<br/>
			<p><a href='site.php'>Revenir</a> &agrave; l'aide du site</p>
			</div>
			<div class="bas"></div>				
		</div>
		
	

	</div><!-- fin contenu -->
	

<?php 
$pageHTML->bas();




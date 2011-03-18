<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());


$pageHTML->haut();
$pageHTML->menu();
?>
	
	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Mentions Légales</h2></div>
			<div class="cont">
			<p>Le site zencancan.com est édité par Sigmalis SARL</p>
		<br/>
		
<h3>Informations légales</h3>
			<p>
<pre>
SIGMALIS
SARL au capital de 3000 Euros.
RCS LYON : 493 587 273 00019
NAF : 722C
Numéro de TVA Intracommunautaire : FR86493587273

Siège social :
31 avenue des frères Lumières
69008 LYON
Mél: web arrobasse sigmalis point com
Tél: 06 81 62 12 82
</pre>
</p>
			</div>
			<div class="bas"></div>				
		</div>
		
	

	</div><!-- fin contenu -->
	

<?php 
$pageHTML->bas();




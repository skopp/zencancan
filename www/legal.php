<?php

require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

$pageHTML = new PageHTML($id,$debut,$authentification->getNamedAccount());


$pageHTML->haut();
$pageHTML->menu();
?>
	
	<div id="contenu">
	
		<div class="box">
			<div class="haut"><h2>Mentions L&eacute;gales</h2></div>
			<div class="cont">
			<p>Le site zencancan.com est &eacute;dit&eacute; par</p>
		<br/>
		



<p>
<img src="img/commun/mentions-legales.png" alt="" />
</p>
			</div>
			<div class="bas"></div>				
		</div>
		
	

	</div><!-- fin contenu -->
	

<?php 
$pageHTML->bas();




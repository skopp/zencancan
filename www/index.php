<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PasswordGenerator.class.php");
require_once("PageHTML.class.php");
require_once("AbonnementSQL.class.php");
require_once("FancyDate.class.php");
require_once("util.php");

$recuperateur = new Recuperateur($_GET);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$fancyDate = new FancyDate();

$id = $recuperateur->get('id');

if (strlen($id) > 16 ){
	setcookie("id","");
	$id = "";
}

if (isset($_COOKIE['id'])){
	if (! $id ){
		header("Location: index.php?id=".$_COOKIE['id']);
		exit;
	}
	if ($id !=  $_COOKIE['id'] ){
		setcookie("id",$id);
		header("Location: index.php?id=$id");
		exit;
	} 
}

if (! $id ){
	
	$passwordGenerator = new PasswordGenerator();
	$id = $passwordGenerator->getPassword();
	setcookie("id",$id);
	header("Location: index.php?id=$id");
	exit;
}

$allFlux = $abonnementSQL->getAll($id);


$pageHTML = new PageHTML($debut);

$pageHTML->haut($id);

?>
<p>
Votre identifiant : <?php hecho($id) ?>
</p>

<form action='add-flux.php' method='post'>
<input type='hidden' name='id'  value='<?php hecho($id) ?>' />
Site à suivre: <br/>
<?php if ($lastMessage->getLastMessage()) : ?>
<p>
<?php echo $lastMessage->getLastMessage(); ?>
</p>
<?php endif;?>
<input type='text' size='50' name='url' />
<input type='submit' value='Suivre' />
</form>
<p class='petit'>Exemple: L'Equipe, Le Monde, Morandini, ...</p>

<?php if ($allFlux) : ?>
<h2>Dernières mises à jour : </h2>
<table>
<?php foreach($allFlux as $flux) : ?>
	<tr>
		<td class='date'><a name='' title='Dernier passage : <?php echo $fancyDate->get($flux['last_recup'])?>'><?php echo $fancyDate->get($flux['last_maj'])?></a></td>
			<td><form method='post' action='del.php'>
				<input class='bouton' type='submit' value='X'/>
				<input type='hidden' name='id' value='<?php echo $id ?>'/>
				<input type='hidden' name='id_f' value='<?php echo $flux['id_f']?>'/>
			</form>
		</td>
		<td class='site'><a href='<?php hecho($flux['link'])?>' target='_blank'><?php hecho($flux['title'])?></a></td>
	
		<td class='lien'><a href='<?php hecho($flux['item_link'])?>' target='_blank'><?php hecho($flux['item_title']) ?></a></td>
		
	</tr>
<?php endforeach;?>
</table>
<?php endif;?>
<?php 
$pageHTML->bas();




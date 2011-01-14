<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PasswordGenerator.class.php");
require_once("PageHTML.class.php");
require_once("AbonnementSQL.class.php");
require_once("FancyDate.class.php");

$recuperateur = new Recuperateur($_GET);
$abonnementSQL = new AbonnementSQL($sqlQuery);
$fancyDate = new FancyDate();

$id = $recuperateur->get('id');

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
Votre identifiant : <?php echo $id ?>
</p>

<form action='add-flux.php' method='post'>
<input type='hidden' name='id' value='<?php echo $id?>' />
URL du site à suivre: <br/>
<?php if ($lastMessage->getLastMessage()) : ?>
<p>
<?php echo $lastMessage->getLastMessage(); ?>
</p>
<?php endif;?>
<input type='text' name='url' />

<input type='submit' value='Aggréger' />

</form>

<?php if ($allFlux) : ?>
<br/><br/>
<h2>Dernières mise à jour : </h2>
<table>
<?php foreach($allFlux as $flux) : ?>
	<tr>
		<td><?php echo $fancyDate->get($flux['last_maj'])?></td>
		<td><a href='<?php echo $flux['link']?>'><?php echo $flux['title']?></a></td>
		
	</tr>
<?php endforeach;?>
</table>
<?php endif;?>
<?php 
$pageHTML->bas();




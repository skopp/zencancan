<?php

require_once( dirname(__FILE__)."/../init.php");
require_once("PasswordGenerator.class.php");
require_once("PageHTML.class.php");

$recuperateur = new Recuperateur($_GET);

$id = $recuperateur->get('id');

if (! $id ){
	$passwordGenerator = new PasswordGenerator();
	$id = $passwordGenerator->getPassword();
	header("Location: index.php?id=$id");
}

$pageHTML = new PageHTML($debut);

$pageHTML->haut($id);
?>
<p>
Votre identifiant : <?php echo $id ?>
</p>

<form action='add-flux.php' method='post'>
<input type='hidden' name='id' value='<?php echo $id?>' />
Aggréger un flux RSS (URL) : <br/>
<?php if ($lastMessage->getLastMessage()) : ?>
<p>
<?php echo $lastMessage->getLastMessage(); ?>
</p>
<?php endif;?>
<input type='text' name='url' />

<input type='submit' value='Aggréger' />

</form>

<?php 
$pageHTML->bas();

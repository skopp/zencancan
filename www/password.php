<?php
require_once( __DIR__."/../init-web.php");
require_once("PageHTML.class.php");

if (!$authentification->getNamedAccount()){
	header("Location: index.php");
	exit;
}

$pageHTML = new PageHTML($id,$debut);

$pageHTML->haut();
?>

<a href='param.php'>&laquo; Revenir aux param&egrave;tres du compte </a>


<div class="box">
			<div class="haut">
<h2>Modifier de votre mot de passe</h2>
	</div>
<div class="cont">
	
<?php if ($lastMessage->getLastMessage()) : ?>
	<p><?php echo $lastMessage->getLastMessage(); ?></p>
<?php endif;?>
<form action='password-controler.php' method='post'>
	<label for="oldpassword">Votre ancien mot de passe</label>
	<input type='password' name='oldpassword'/>
	<hr/>
	<label for="password">Nouveau mot de passe</label>
	<input type='password' name='password'/>
	<hr/>
	<label for="password2">Nouveau mot de passe (v&eacute;rification)</label>
	<input type='password' name='password2'/><br/>
	<hr/>
	<input type='submit' class='submit' value='Modifier'/>
</form>
</div>
</div>
<?php 
$pageHTML->bas();
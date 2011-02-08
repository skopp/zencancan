<?php
require_once( __DIR__."/../init-web.php");

require_once( "Recuperateur.class.php");
require_once( "ZenMail.class.php");
require_once( "util.php"); 

$recuperateur = new Recuperateur($_POST);

$info['sujet'] = $recuperateur->get("sujet");
$info['message']  = $recuperateur->get("message");
$email = $recuperateur->get("email");


if (! $email){
	header("Location: index.php");
	exit;
}

$zMail = new ZenMail();
$zMail->setEmmeteur("",$email);

$zMail->setDestinataire(EMAIL_CONTACT);
$zMail->setSujet("[contact] " . $info['sujet'] );
$zMail->setContenu( __DIR__ . "/../mail/contact.php" ,$info );
$zMail->send();
		
$zMail->setEmmeteur(EMAIL_DESCRIPTION,EMAIL_CONTACT);
$zMail->setDestinataire($email);
$zMail->setSujet("[contact] " . $info['sujet'] );
$zMail->setContenu(  DIR . "/../mail/contact-ar.php" ,$info );
$zMail->send();

		
header("Location: contact-ok.php");
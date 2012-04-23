<?php
class ContactControler extends ZenCancanControler {
	
	public function indexAction($id_f = false){
		if ($id_f){
			$this->LastMessage->setInput("sujet","Problème sur le flux #$id_f");
		}
		$this->Gabarit->template_milieu = "Contact";
		$this->renderDefault();
	}
	
	public function doContactAction(){

		$info['sujet'] = $this->Recuperateur->get("sujet");
		$info['message']  = $this->Recuperateur->get("question");
		$email = $this->Recuperateur->get("email");

		if (! $email){
			$this->LastMessage->setLastError("Vous devez indiqué un email");
			$this->redirect("/Contact/index");
		}

		$this->ZenMail->setEmmeteur("",$email);

		$this->ZenMail->setDestinataire(EMAIL_CONTACT);
		$this->ZenMail->setSujet("[contact] " . $info['sujet'] );
		$this->ZenMail->setContenu( __DIR__ . "/../mail/contact.php" ,$info );
		$this->ZenMail->send();
		
		$this->ZenMail->setEmmeteur(EMAIL_DESCRIPTION,EMAIL_CONTACT);
		$this->ZenMail->setDestinataire($email);
		$this->ZenMail->setSujet("[contact] " . $info['sujet'] );
		$this->ZenMail->setContenu(  __DIR__ . "/../mail/contact-ar.php" ,$info );
		$this->ZenMail->send();

		$this->LastMessage->setLastMessage("Votre message a été envoyé");
		$this->redirect();
	}
	
	

	
}
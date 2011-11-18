<?php
class ZenCancanFrontControler extends FrontControler {
	
	public function noToken(){
		$username = $this->Authentification->getNamedAccount();
		$location = $this->Path->getPathWithUsername($username,"");
		$this->LastMessage->setLastError("Ooops... un problème a été detecté sur le formulaire");
		header("Location: $location");
		exit;
	}
		
	public function go(){
		if ($this->Authentification->getNamedAccount() && isset($_COOKIE['remember_zencancan'])) {
			$id_u = $this->UtilisateurSQL->verifRemember($this->Authentification->getNamedAccount(),$_COOKIE['remember_zencancan']);
			if ($id_u){
				$this->Connexion->login($id_u);
				$this->UtilisateurSQL->updateLastLogin($id_u);	
			}
		}
		if ($this->Authentification->getNamedAccount()){
			if ($this->Connexion->isConnected()){	
				$this->objectInstancier->defaultControler = "Feed";
				$this->objectInstancier->defaultAction = "List";
			} else {
				$this->objectInstancier->defaultControler = "Mur";
				$this->objectInstancier->defaultAction = "index";
			}
		} else {
			$this->objectInstancier->defaultControler = "Aide";
			$this->objectInstancier->defaultAction = "Presentation";
		}
		parent::go();
		
	}
	
	
}
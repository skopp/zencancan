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
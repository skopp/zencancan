<?php
class ZenCancanFrontControler extends FrontControler {
	
	public function noToken(){
		$this->LastMessage->setLastError("Ooops... un problème a été detecté sur le formulaire");
		$location = $this->Path->getPath("");
		header("Location: $location");		
		exit;
	}
		
	public function go(){
		if (isset($_COOKIE['remember_zencancan'])) {
			$info = $this->UtilisateurSQL->getInfoFromRemember($_COOKIE['remember_zencancan']);
			if ($info){
				$this->Connexion->login($info['id_u'],$info['name']);
				$this->UtilisateurSQL->updateLastLogin($info['id_u']);	
			}
		}
		if ($this->Connexion->isConnected()){	
			$this->objectInstancier->defaultControler = "Feed";
			$this->objectInstancier->defaultAction = "List";
		} else {
			$this->objectInstancier->defaultControler = "Aide";
			$this->objectInstancier->defaultAction = "Presentation";
		}
		parent::go();
	}
}
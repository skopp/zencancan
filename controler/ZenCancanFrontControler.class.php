<?php
class ZenCancanFrontControler extends FrontControler {
	
	public function noToken(){
		$username = $this->Authentification->getNamedAccount();
		$location = $this->Path->getPathWithUsername($username,"");
		$this->LastMessage->setLastError("Ooops... un problème a été detecté sur le formulaire");
		header("Location: $location");
		exit;
	}
	
	
}
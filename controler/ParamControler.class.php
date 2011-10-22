<?php
class ParamControler extends ZenCancanControler {
	
	public function indexAction($id){
		$this->Gabarit->template_milieu = "Param";
		$this->renderDefault($id);
	}
	
	public function adminAction(){		
		if ( ! $this->Compte->isAdmin($this->Authentification->getId())){
			header("Location: index.php");
			exit;
		}
		$this->Gabarit->infoFeed = $this->FeedSQL->feedInfo();
		$this->Gabarit->template_milieu = "Admin";
		
		$this->renderDefault($this->Authentification->getId());
	}
	
	public function aideAction(){
		$this->Gabarit->template_milieu = "Aide";
		$this->renderDefault($this->Authentification->getId());
	}
	
	public function legalAction(){
		$this->Gabarit->template_milieu = "Legal";
		$this->renderDefault($this->Authentification->getId());
	}
	
}
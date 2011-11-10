<?php
class AdminControler extends ZenCancanControler {
	
	public function fluxAction(){		
		$id_u = $this->verifAdmin(); 
		$this->Gabarit->infoFeed = $this->FeedSQL->feedInfo();
		$this->Gabarit->template_milieu = "Admin";
		$this->renderDefault();
	}
	
	public function userListAction($offset = 0){
		$id_u = $this->verifAdmin();
		$this->Gabarit->all_user = $this->UtilisateurSQL->getAll($offset);
		$this->Gabarit->template_milieu = "UserList";
		$this->renderDefault();
	}
	
}
<?php
class AdminControler extends ZenCancanControler {
	
	public function fluxAction($tri = "last_login",$offset = 0){		
		$id_u = $this->verifAdmin(); 
		$this->Gabarit->infoFeed = $this->FeedSQL->feedInfo();
		$this->Gabarit->all_user = $this->UtilisateurSQL->getAll($tri,$offset);
		
		$this->Gabarit->template_milieu = "Admin";
		$this->renderDefault();
	}
}
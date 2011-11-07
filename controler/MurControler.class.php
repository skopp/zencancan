<?php
class MurControler extends ZenCancanControler {
	
	
	public function indexAction($offset = 0){
		$name_account = $this->Authentification->getNamedAccount();
		$id_u = $this->UtilisateurSQL->getIdFromUsername($name_account);
		if (! $id_u){
			$this->redirectWithUsername("");
		}
		$this->Gabarit->all_item = $this->MurSQL->getLastItem($id_u,$offset);
		$this->Gabarit->name_account = $this->Authentification->getFullAccountName();
		
		$this->Gabarit->template_milieu = "Mur";
		$this->renderDefault("");
	}
	
	public function doAddAction(){
		$id_u = $this->verifConnected();
		$content = $this->Recuperateur->get("content");
		$title = "Message de " . $this->Authentification->getNamedAccount();
		$this->MurSQL->add($id_u,$content,$title,$this->Path->getPath());
		$this->redirect("/Mur/index");		
	}
	
	public function doDeleteAction($id_m){
		$id_u = $this->verifConnected();
		$this->MurSQL->delete($id_u,$id_m);
		$this->redirect("/Mur/index");
		
	}
	
	
}
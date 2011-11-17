<?php
class MurControler extends ZenCancanControler {
	
	
	private function getAllItem($name_account,$offset = 0){
		$id_u = $this->UtilisateurSQL->getIdFromUsername($name_account);
		if (! $id_u){
			$this->redirectWithUsername("");
		}
		return $this->MurSQL->getLastItem($id_u,$offset);
	}
	
	public function indexAction($offset = 0){
		$name_account = $this->Authentification->getNamedAccount();
		$this->Gabarit->all_item = $this->getAllItem($name_account,$offset);
		
		$this->addRSS("Mur de $name_account",$this->Path->getPath("/Mur/rss"));
		
		$this->Gabarit->name_account = $this->Authentification->getFullAccountName();		
		$this->Gabarit->template_milieu = "Mur";
		
		$this->renderDefault("");
	}
	
	public function rssAction(){
		$name_account = $this->Authentification->getNamedAccount();
		$all_item = $this->getAllItem($name_account);
		$full_name = $this->Authentification->getFullAccountName();						
		$rssCreator = new RSSCreator("$full_name","$full_name",   $this->Path->getPath("/Mur/index") );
		
		foreach($all_item as $item){
			$rssCreator->addItem($item['title'] ,$item['link'],$item['date'],$item['content']);
		}
		echo $rssCreator->getRSS();
	}
	
	
	public function doAddAction(){
		$id_u = $this->verifConnected();
		$content = $this->Recuperateur->get("content");
		$title = "Message de " . $this->Authentification->getNamedAccount();
		$this->MurSQL->add($id_u,$content,$title,"");
		$this->redirect("/Mur/index");		
	}
	
	public function doDeleteAction($id_m){
		$id_u = $this->verifConnected();
		$this->MurSQL->delete($id_u,$id_m);
		$this->redirect("/Mur/index");
	}
	
	
}
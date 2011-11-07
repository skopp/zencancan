<?php
class MurControler extends ZenCancanControler {
	
	
	public function indexAction(){
		$this->Gabarit->template_milieu = "Mur";
		$this->renderDefault("");
	}
	
	public function doAddAction(){
		$id = $this->verifConnected();
		//$id_u = $this->Co 
		$content = $this->Recuperateur->get("content");
		$this->MurSQL->add($id_u,$content);
		$this->redirect("/Mur/index");		
	}
	
	
}
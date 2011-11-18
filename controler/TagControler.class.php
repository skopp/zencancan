<?php


class TagControler extends ZenCancanControler {

	public function delAction($id_f,$tag){
		$id_u = $this->verifConnected();
		$this->AbonnementSQL->delTag($id_u,$id_f,$tag);
		$this->redirect("/Feed/detail/$id_f");
	}
	
	public function doAddAction(){
		$id_u = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$tag = $this->Recuperateur->get('tag');
		$this->AbonnementSQL->addTag($id_u,$id_f,$tag);
		if ($tag){
			$this->LastMessage->setLastMessage("Ajout de l'étiquette $tag");
		} 
		$this->redirect("/Feed/detail/$id_f");
		
	}
}
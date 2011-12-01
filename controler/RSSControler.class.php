<?php
class RSSControler extends ZenCancanControler {
	
	public function allAction($id,$tag=""){
		
		$id_u = $this->UtilisateurSQL->getIdFromUsername($this->Authentification->getNamedAccount());
		$info = $this->UtilisateurSQL->getInfo($id_u);
		
		
		if ($id != $info['id']){
			$this->redirect("");
		}
		
		$rssCreator = new RSSCreator("zenCancan - flux $id : $tag","Flux pour l'id $id : $tag",   $this->Path->getPath() );
		
		
		$allFlux = $this->AbonnementSQL->getWithContent($id_u,0,$tag);

		foreach($allFlux as $flux){
			$rssCreator->addItem($flux['title'] . ": " .$flux['item_title'],$flux['item_link'],$flux['last-modified'],$flux['item_content'],$flux['item_description']);
		}

		echo $rssCreator->getRSS();
	}
	
}
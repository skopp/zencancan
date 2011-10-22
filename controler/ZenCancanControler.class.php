<?php
class ZenCancanControler extends Controler {
	
	public function renderDefault($id,$tag = false){
		$rss[] = array('title' => "Votre flux zencancan",'url' => "rss.php?id=$id");
		if ($tag){
			$rss[] = array('title'=>"Votre flux zencancan - $tag",'url' => "rss.php?id=$id&tag=$tag");
		}
		
		$this->Gabarit->rss =  $rss;
		$this->Gabarit->id = $id;
		$this->Gabarit->namedAccount = $this->Authentification->getNamedAccount();
		$this->Gabarit->isAdmin  = $this->Compte->isAdmin($this->Authentification->getId());
		$this->Gabarit->tag = $tag;
		$this->Gabarit->revision_number = $this->revision_number;
		$this->Gabarit->render("Page");
	}
	
	
}
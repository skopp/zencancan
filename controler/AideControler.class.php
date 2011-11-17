<?php

class AideControler extends ZenCancanControler {
	
	public function PresentationAction(){		
		if ($this->presentation_page){
			include($this->presentation_page);
		} else {
			$this->Gabarit->template_milieu = "Login";
			$this->renderDefault();
		}
	}
	
	public function indexAction(){
		$this->Gabarit->template_milieu = "Aide";
		$this->renderDefault();
	}
	
	public function licenceAction(){
		$this->Gabarit->template_milieu = "Licence";
		$this->renderDefault();
	}
	
}
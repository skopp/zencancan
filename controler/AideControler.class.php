<?php

class AideControler extends ZenCancanControler {
	
	public function PresentationAction(){		
		$this->Gabarit->template_milieu = "Presentation";
		$this->renderDefault("");
	}
	
	public function indexAction(){
		$this->Gabarit->template_milieu = "Aide";
		$this->renderDefault("");
	}
	
}
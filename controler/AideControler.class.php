<?php

class AideControler extends ZenCancanControler {
	
	public function PresentationAction(){
		$this->Gabarit->debut = $this->debut;
		$this->Gabarit->render("Presentation");
	}
	
}
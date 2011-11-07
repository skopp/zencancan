<?php

class AideControler extends ZenCancanControler {
	
	public function PresentationAction(){		
		$this->Gabarit->template_milieu = "Presentation";
		$this->renderDefault("");
	}
	
}
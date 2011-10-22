<?php
class ConnexionControler extends ZenCancanControler {
	
	public function loginAction($id){
		$this->Gabarit->template_milieu = "Login";
		$this->renderDefault($id);
	}
	
	
}
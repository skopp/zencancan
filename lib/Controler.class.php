<?php
class Controler {

	private $objectInstancier;
	
	private $selectedView;
	private $viewParameter;
	
	public function __construct(ObjectInstancier $objectInstancier){
		$this->objectInstancier = $objectInstancier;
		$this->viewParameter = array();
	}

	public function __get($key){
		return $this->objectInstancier->$key;
	}

	public function __set($key,$value){
		$this->viewParameter[$key] = $value;
		$this->$key  = $value;
	}
	
	public function getViewParameter(){
		return $this->viewParameter;
	}
	
	public function selectView($view){
		$this->selectedView = $view;
	}
	
	public function getSelectedView(){
		return $this->selectedView;
	}
	
	/*public function exitIfNotConnected(){
		if (! $this->ConnexionSQL->isConnected()){
			$this->redirect("Login","index");
		}
	}
	
	public function exitToIndex(){
		header("Location: ".$this->objectInstancier->site_base);
		exit;
	}
	
	public function redirect($controler,$action,$param = ""){
		header("Location: {$this->objectInstancier->site_base}/index.php/$controler/$action/$param");
		exit;
	}*/
	
}

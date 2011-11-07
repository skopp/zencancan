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
}

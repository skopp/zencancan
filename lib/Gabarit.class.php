<?php
class Gabarit {
	
	private $viewParameter;
	private $objectInstancier;
	
	public function __construct(ObjectInstancier $objectInstancier){
		$this->viewParameter = array();
		$this->objectInstancier = $objectInstancier;
		$this->viewParameter['site_base'] = $this->objectInstancier->site_base; 
		$this->viewParameter['site_script'] = $this->objectInstancier->site_script; 
		
		$this->viewParameter['debut'] = $this->objectInstancier->debut;
	}
	
	public function __set($key,$value){
		$this->viewParameter[$key] = $value;
	}
	
	public function setParameters(array $parameter){
		$this->viewParameter = array_merge($this->viewParameter,$parameter); 
	}
	
	public function render($template){
		
		foreach($this->viewParameter as $key => $value){
			$$key = $value;
		}		
		include("{$this->template_path}/$template.php");
	}
	
	public function __get($key){
		return $this->objectInstancier->$key;
	}
}
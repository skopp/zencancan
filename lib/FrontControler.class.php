<?php
class FrontControler extends Controler {
	
	private $object;

	public function go(){		
		$path_token = $this->PathInfo->getInfo($this->getPathInfo());	
		$this->defaultAction($path_token);
		$controler = $this->doAction($path_token);		
	}
	
	private function getPathInfo(){
		if ($_SERVER['REQUEST_METHOD'] != 'POST'){
			return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:"";
		}
		$this->ConnexionSQL->verifToken() or $this->exitToIndex();		
		
		return $this->Recuperateur->get('path_info');
	}
	
	private function doAction($path_token){
		try {
			$reflexionClass = new ReflectionClass($path_token['controler']);
		} catch (Exception $e){		
			
			return $this;
		}
		if (! $reflexionClass->hasMethod($path_token['action'])){
			return $this;
		}
		$controler = $this->$path_token['controler'];	
		$controler -> selectView($path_token['defaultView']);	
		call_user_func_array(array($controler,$path_token['action']),$path_token['param']);		
		
		return $controler;
	}
	
	private function defaultAction($path_token){
		$this->selectView($path_token['defaultView']);
	}
	
}

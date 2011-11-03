<?php
abstract class FrontControler extends Controler {
	
	private $object;

	abstract public function noToken();
	
	public function go(){		
		$path_token = $this->PathInfo->getInfo($this->getPathInfo());
		$controler = $this->doAction($path_token);		
	}
	
	private function getPathInfo(){
		if ($_SERVER['REQUEST_METHOD'] != 'POST'){
			return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:"";
		}
		if ( ! $this->Connexion->verifToken()){
			$this->noToken();
		}		
		
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
		call_user_func_array(array($controler,$path_token['action']),$path_token['param']);				
		return $controler;
	}
	

	
}

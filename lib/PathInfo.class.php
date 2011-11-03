<?php
class PathInfo {
	
	const DEFAULT_CONTROLER = "Default";
	const DEFAULT_ACTION = "index";
	
	private $defaultControler;
	private $defaultAction;
	
	public function __construct($defaultControler,$defaultAction){
		if (! $defaultControler){
			$defaultControler = self::DEFAULT_CONTROLER;
		}
		if ( ! $defaultAction){
			$defaultAction = self::DEFAULT_ACTION;
		}
		
		$this->defaultControler = $defaultControler;
		$this->defaultAction = $defaultAction;
	}
	
	public function getInfo($pathInfo){
		$controler = $this->defaultControler;
		$action = $this->defaultAction;
		$param = array();
		
		$token = explode("/",$pathInfo);
		
		if (count($token) > 1){
			$controler = ucfirst($token[1]);
		}
		
		if (count($token) > 2){
			$action = $token[2];
		}
		
		if (count($token) > 3) {
			$param = array_slice($token,3);
		}
		
		return array("controler"=>$controler."Controler","action" => $action."Action","param"=>$param,"defaultView"=>"$controler".ucfirst($action));
	}	
}

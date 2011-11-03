<?php

class Authentification {

	private $idHasChanged;
	
	public function setId($id){
		$_SESSION['id'] = $id ;
		$this->idHasChanged = true;
	}
	
	public function getFullAccountName() {
		return $this->getNamedAccount() . "." . DOMAIN_NAME;
	}
	
	public function hasChangedId(){
		return ($this->idHasChanged &&  ! $this->getNamedAccount());
	}
	
	public function getNamedAccount(){
		$server_name = $_SERVER['SERVER_NAME'];
		return strstr($server_name,"." . DOMAIN_NAME,true);
	}
	
	public function getId(){				
		if (empty($_SESSION['id'])){
			return false;
		}
		return $_SESSION['id'];
	}
	
	public function logout(){	
		setcookie('remember_zencancan',"");
		session_destroy();
	}
	
}

<?php

class Authentification {

	private $passwordGenerator;
	private $idHasChanged;
	
	
	public function __construct(PasswordGenerator $passwordGenerator){
		$this->passwordGenerator = $passwordGenerator;
	}
	
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
		if ($this->getNamedAccount() ){
			if (empty($_SESSION['id'])){
				return false;
			}
			return $_SESSION['id'];
		}
			
		if (isset($_REQUEST['id']) && strlen($_REQUEST['id']) < 16  ){
			$id = $_REQUEST['id'];
			$this->setId($id);
			return $id;
		} 
		
		if(isset($_SESSION['id'])) {
			return $_SESSION['id'];
		}
		
		$id = $this->passwordGenerator->getPassword();
		$this->setId($id);
		return $id;
	}
	
	public function logout(){	
		session_destroy();
	}
	
}

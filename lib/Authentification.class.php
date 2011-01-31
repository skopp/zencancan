<?php

class Authentification {

	private $passwordGenerator;
	
	public function __construct(PasswordGenerator $passwordGenerator){
		$this->passwordGenerator = $passwordGenerator;
	}
	
	public function setId($id){
		$_SESSION['id'] = $id ;
	}
	
	public function isNamedAccount(){
		$server_name = $_SERVER['SERVER_NAME'];
		return strstr($server_name,"." . DOMAIN_NAME,true);
	}
	
	public function getId(){		
		if ($this->isNamedAccount() ){
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
	
}
/*
 * 
 * if (strlen($id) > 16 ){
	setcookie("id","");
	$id = "";
}

if (isset($_COOKIE['id'])){
	if (! $id ){
		header("Location: index.php?id=".$_COOKIE['id']);
		exit;
	}
	if ($id !=  $_COOKIE['id'] ){
		setcookie("id",$id);
		header("Location: index.php?id=$id");
		exit;
	} 
}

if (! $id ){
	$passwordGenerator = new PasswordGenerator();
	$id = $passwordGenerator->getPassword();
	setcookie("id",$id);
	header("Location: index.php?id=$id");
	exit;
}

 */
/*
 * 
		if (  ! $username ){
			if (isset($_REQUEST['id'])){
				return $id;
			}
		}
		
			if ($username){
				if ($compte->exists($username)){
					if ( ! in_array(basename($_SERVER['PHP_SELF']),array('login.php','login-controler.php') )) {
						header("Location: login.php");
						exit;
					}
				} else {
					header("Location: http://".DOMAIN_NAME);
					exit;
				}
			}
		}
		
		
		return false;
	
 */
<?php
class Connexion {
	
	public function setConnexion($id_u,$email){
		$_SESSION['connexion']['id_u'] = $id_u;
		$_SESSION['connexion']['email'] = $email;
	}
	
	public function isConnected(){
		return isset($_SESSION['connexion']);
	}
	
	public function getEmail(){
		assert('$this->isConnected()');
		return $_SESSION['connexion']['email'];
	}
	
	public function getId(){
		if (! $this->isConnected()){
			return false;
		}
		return $_SESSION['connexion']['id_u'];
	}
	
	public function deconnexion(){
		unset($_SESSION['connexion']);
	}
	
	public function getToken(){
		if (empty($_SESSION['token'])){
			$_SESSION['token'] = sha1(mt_rand(0,mt_getrandmax()));
		}
		return $_SESSION['token'];
	}
	
	public function displayTokenField(){
		?>
		<input type='hidden' name='token' value='<?php hecho($this->getToken()) ?>' />
		<?php 
	}
	
	public function verifToken($token = false){
		if (! $token && isset($_POST['token'])){
			$token = $_POST['token'];
		}
		return  $token == $this->getToken();
	}
}
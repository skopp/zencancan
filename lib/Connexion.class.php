<?php
class Connexion {
	
	const ID_U = "zencancan_id_u";
	
	public function login($id_u){
		$_SESSION['connexion'][self::ID_U] = $id_u;
	}
	
	public function isConnected(){
		return isset($_SESSION['connexion']);
	}
	
	public function getId(){
		if (! $this->isConnected()){
			return false;
		}
		return $_SESSION['connexion'][self::ID_U];
	}
	
	public function logout(){
		
		unset($_SESSION['connexion']);
		session_destroy();
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
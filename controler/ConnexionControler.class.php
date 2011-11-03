<?php
class ConnexionControler extends ZenCancanControler {
	
	public function loginAction(){
		$this->Gabarit->template_milieu = "Login";
		$this->renderDefault();
	}
	
	public function setRemember($id){
		$remember = $this->Compte->getRemember($id);
		setcookie("remember_zencancan",$remember,time()+3600*24*365);
	}
	
	public function doLoginAction(){
		
		$login = $this->Recuperateur->get('login');
		$password = $this->Recuperateur->get("password");
		$remember = $this->Recuperateur->get('remember');
		$username = $login?:$this->getAccountName();
		
		$id = $this->Compte->verif($username,$password);

		if ( ! $id ){
			$this->LastMessage->setLastError("Le mot de passe est incorrect");
			$this->redirect("/Connexion/login");		
		}	
		if ($login){		
			$verif_id = md5(mt_rand(0,mt_getrandmax()));
			apc_store("verif_$id",$verif_id,60);
			$this->redirectWithUsername($username,"/Connexion/autoLogin/$verif_id/$remember");
		} else {
			if ($remember){
				$this->setRemember($id);	
			}
			$this->Authentification->setId($id);			
			$this->redirect("/Feed/list");
		}
	}
	
	public function doLogoutAction(){
		$this->Authentification->logout();
		$this->redirectWithUsername("","/Connexion/login");
	}
	
	public function autoLoginAction($verif_id,$remember){
		if ( ! $verif_id){
			$this->redirect();
		}

		$username = $this->getAccountName();
		$id  = $this->Compte->getId($username);
		
		if (apc_fetch("verif_$id") != $verif_id){
			$this->redirect();
		}
		$this->Path->setUsername($username);
		$this->Authentification->setId($id);
		if ($remember){
			$this->setRemember($id);	
		}
		
		$this->redirect();
	}
	
	
}
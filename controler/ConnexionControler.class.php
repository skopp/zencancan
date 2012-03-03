<?php
class ConnexionControler extends ZenCancanControler {
	
	public function loginAction(){
		$this->Gabarit->template_milieu = "Login";
		$this->renderDefault();
	}
	
	public function setRemember($id_u){
		$remember = $this->UtilisateurSQL->getRemember($id_u);
		setcookie("remember_zencancan",$remember,time()+3600*24*365,"/");
	}
	
	public function doLoginAction(){	
		$login = $this->Recuperateur->get('login');
		$password = $this->Recuperateur->get("password");
		$remember = $this->Recuperateur->get('remember');
		
		$id_u = $this->UtilisateurSQL->verif($login,$password);

		if ( ! $id_u ){
			$this->LastMessage->setLastError("Le mot de passe est incorrect");
			$this->redirect("/Connexion/login");		
		}	
		if ($remember){
			$this->setRemember($id_u);	
		} 
		$this->Connexion->login($id_u,$login);		
		$this->UtilisateurSQL->updateLastLogin($id_u);	
		$this->redirect("/Feed/list");
	}
	
	public function doLogoutAction(){		
		setcookie('remember_zencancan',"",1,"/");
		$this->Connexion->logout();
		$this->redirect();
	}
	
}
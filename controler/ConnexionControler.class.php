<?php
class ConnexionControler extends ZenCancanControler {
	
	public function loginAction(){
		$this->Gabarit->template_milieu = "Login";
		$this->renderDefault();
	}
	
	public function setRemember($id_u){
		$remember = $this->UtilisateurSQL->getRemember($id_u);
		setcookie("remember_zencancan",$remember,time()+3600*24*365);
	}
	
	public function doLoginAction(){
	
		$login = $this->Recuperateur->get('login');
		$password = $this->Recuperateur->get("password");
		$remember = $this->Recuperateur->get('remember');
		$username = $login?:$this->getAccountName();
		
		$id_u = $this->UtilisateurSQL->verif($username,$password);

		if ( ! $id_u ){
			$this->LastMessage->setLastError("Le mot de passe est incorrect");
			$this->redirect("/Connexion/login");		
		}	
		if ($login){		
			$verif_id = md5(mt_rand(0,mt_getrandmax()));
			apc_store("verif_$id_u",$verif_id,60);
			$this->redirectWithUsername($username,"/Connexion/autoLogin/$verif_id/$remember");
		} else {
			if ($remember){
				$this->setRemember($id_u);	
			}
			$this->Connexion->login($id_u);			
			$this->redirect("/Feed/list");
		}
	}
	
	public function doLogoutAction(){
		$this->Connexion->logout();
		$this->redirectWithUsername("","/Connexion/login");
	}
	
	public function autoLoginAction($verif_id,$remember){
		
		if ( ! $verif_id){
			$this->redirect();
		}

		$username = $this->getAccountName();
		$id_u  = $this->UtilisateurSQL->getIdFromUsername($username);
		
		if (apc_fetch("verif_$id_u") != $verif_id){
			$this->redirect();
		}
		$this->Path->setUsername($username);
		$this->Connexion->login($id_u);
		if ($remember){
			$this->setRemember($id_u);	
		}
		
		$this->redirect();
	}
	
	
}
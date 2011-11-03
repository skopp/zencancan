<?php


class AccountControler extends ZenCancanControler {
	
	public function createAction(){
		
		$this->Gabarit->template_milieu = "AccountCreate";
		$this->renderDefault();
	}
	
	protected function sortir($message){
		parent::sortir($message,"/Account/create");
	}
	
	
	public function doCreateAction(){		
		$name = $this->Recuperateur->get('name');
		$password = $this->Recuperateur->get('password');
		$password2 = $this->Recuperateur->get('password2');

		if (! $name){
			$this->sortir("Il faut spécifier un nom de compte");
		}
		
		if ($password != $password2){
			$this->sortir("Les mots de passe ne correspondent pas");
		}
		
		$id = $this->PasswordGenerator->getPassword();
		
		$result = $this->Compte->create($id,$name,$password);
		if (! $result){
			$this->sortir($this->Compte->getLastError());
		}
		
		$this->Authentification->logout();
		$this->redirectWithUsername($name);
	}
}
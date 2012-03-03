<?php
class ZenCancanControler extends Controler {
	
	protected $rss;
	
	public function __construct(ObjectInstancier $ob){		
		parent::__construct($ob);
		$this->rss = array();
		$this->Gabarit->rss = array();
	}

	protected function addRSS($title,$link){
		$this->rss[] = array('title'=>$title,'url'=>$link);
	}
	
	public function verifConnected(){		
		$id_u = $this->Connexion->getId();
		if (! $id_u){
			$this->redirect("/Connexion/login");
		}
		return $id_u;
	}
	
	public function verifAdmin(){
		$id_u = $this->verifConnected();
		if ( ! $this->UtilisateurSQL->isAdmin($id_u)){
			$this->redirect();
		}
		return $id_u;
	}
	
	public function redirect($to = ""){		
		$location = $this->Path->getPath($to);
		header("Location: $location");
		exit;
	}
	
	protected function redirect2DetailOrRead($info){
		if (! empty($info['last_id_i'])){
			$this->redirect("/Feed/read/{$info['last_id_i']}");
		} 
		
		if(! empty($info['id_f'])) {
			$this->redirect("/Feed/detail/{$info['id_f']}");
		} 
		$this->redirect();
	}
	
	protected function sortir($message,$to){
		$this->LastMessage->setLastError($message);
		$this->redirect($to);
	}
	
	public function renderDefault(){		
		$id_u = $this->Connexion->getId();	
		$this->Gabarit->rss = $this->rss;			
		$this->Gabarit->id_u = $id_u;
		$this->Gabarit->namedAccount = $this->Connexion->getLogin();
		$this->Gabarit->isAdmin  = $this->UtilisateurSQL->isAdmin($id_u);
		$this->Gabarit->debut = $this->debut;
		$this->Gabarit->render("Page");
	}	
}
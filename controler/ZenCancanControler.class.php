<?php
class ZenCancanControler extends Controler {
	
	private $rss;
	
	public function __construct(ObjectInstancier $ob){
		parent::__construct($ob);
		$this->Path->setUsername($this->getAccountName());
		$this->rss = array();
	}
	
	protected function addRSS($title,$link){
		$this->rss[] = array('title'=>$title,'url'=>$link);
	}
	
	public function verifConnected(){		
		$id_u = $this->Connexion->getId();
		if (! $id_u){
			if ($this->Authentification->getNamedAccount() && isset($_COOKIE['remember_zencancan'])) {
				$id_u = $this->UtilisateurSQL->verifRemember($this->Authentification->getNamedAccount(),$_COOKIE['remember_zencancan']);
			}
			if ($id_u){
				$this->Connexion->login($id_u);
			
			} else {			
				$this->redirect("/Connexion/login");
			}
		}
		return $id_u;
	}
	
	public function redirectWithUsername($username = "",$to=""){		
		$location = $this->Path->getPathWithUsername($username,$to);
		header("Location: $location");
		exit;
	}
	
	public function redirect($to = ""){		
		$this->redirectWithUserName($this->getAccountName(),$to);
	}
	
	protected function sortir($message,$to){
		$this->LastMessage->setLastError($message);
		$this->redirect($to);
	}
	
	public function getAccountName(){
		$server_name = $_SERVER['SERVER_NAME'];
		return strstr($server_name,"." . DOMAIN_NAME,true);
	}
	
	public function renderDefault($tag = false){		
		$id_u = $this->Connexion->getId();		
		$info = $this->UtilisateurSQL->getInfo($id_u);
		$id = $info['id'];
		
		$this->addRSS("Votre flux zencancan",$this->Path->getPath("/RSS/all/$id"));
		if ($tag){
			$this->addRSS("Votre flux zencancan - $tag",$this->Path->getPath("/RSS/all/$id/$tag"));
		}
		
		$this->Gabarit->rss = $this->rss;
		$this->Gabarit->id_u = $id_u;
		$this->Gabarit->namedAccount = $this->Authentification->getNamedAccount();
		$this->Gabarit->isAdmin  = $this->UtilisateurSQL->isAdmin($id_u);
		$this->Gabarit->tag = $tag;
		$this->Gabarit->revision_number = $this->revision_number;
		$this->Gabarit->debut = $this->debut;
		$this->Gabarit->render("Page");
	}
	
	
}
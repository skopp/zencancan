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
		$id = $this->Authentification->getId();
		if (! $id){
			if ($this->Authentification->getNamedAccount() && isset($_COOKIE['remember_zencancan'])) {
				$id = $this->Compte->verifRemember($this->Authentification->getNamedAccount(),$_COOKIE['remember_zencancan']);
			}
			if ($id){
				$this->Authentification->setId($id);
			
			} else {			
				$this->redirect("/Connexion/login");
			}
		}
		return $id;
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
		$id = $this->Authentification->getId();		
		
		$this->addRSS("Votre flux zencancan",$this->Path->getPath("/RSS/all/$id"));
		if ($tag){
			$this->addRSS("Votre flux zencancan - $tag",$this->Path->getPath("/RSS/all/$id/$tag"));
		}
		
		$this->Gabarit->rss = $this->rss;
		$this->Gabarit->id = $id;
		$this->Gabarit->namedAccount = $this->Authentification->getNamedAccount();
		$this->Gabarit->isAdmin  = $this->Compte->isAdmin($this->Authentification->getId());
		$this->Gabarit->tag = $tag;
		$this->Gabarit->revision_number = $this->revision_number;
		$this->Gabarit->debut = $this->debut;
		$this->Gabarit->render("Page");
	}
	
	
}
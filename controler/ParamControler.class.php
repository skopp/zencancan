<?php
class ParamControler extends ZenCancanControler {
	
	public function indexAction(){
		$id_u = $this->verifConnected();
		$info = $this->UtilisateurSQL->getInfo($id_u);
		$this->Gabarit->id = $info['id'];
		
		$this->Gabarit->template_milieu = "Param";
		$this->renderDefault();
	}
	
	public function aideAction(){
		$this->Gabarit->template_milieu = "Aide";
		$this->renderDefault();
	}
	
	public function legalAction(){
		$this->Gabarit->mention_legal_content = $this->mention_legal_content;
		$this->Gabarit->template_milieu = "Legal";
		$this->renderDefault();
	}
	
	public function passwordAction(){
		$id = $this->verifConnected();
		$this->Gabarit->template_milieu = "Password";
		$this->renderDefault();
	}
	
	protected function sortir($message){
		parent::sortir($message,"/Param/password");
	}
	
	public function doPasswordAction(){
		$id = $this->verifConnected();
		
		$oldpassword = $this->Recuperateur->get('oldpassword');
		$password = $this->Recuperateur->get('password');
		$password2 = $this->Recuperateur->get('password2');
		
		if ($password != $password2){
			$this->sortir("Les mots de passe ne correspondent pas");
		}
		
		if ( ! $this->UtilisateurSQL->verif($this->Connexion->getLogin(),$oldpassword)){
			$this->sortir("Votre ancien mot de passe est incorrecte");
		}

		$this->UtilisateurSQL->setPassword($id,$password);
		
		$this->LastMessage->setLastMessage("Votre mot de passe a été modifié");
		$this->redirect("/Param/index");
	}
	public function exportAction(){
		$id = $this->verifConnected();
		$this->OPMLWriter->send("zenCancan",$this->AbonnementSQL->getAll($id));
	}
	
	protected function sortirToParam($message){
		parent::sortir($message,"/Param/index");
	}
	
	public function importAction(){
		$id_u = $this->verifConnected();
	
		if (empty($_FILES['fichier_opml'])){
			$this->sortirToParam("Fichier non présents");	
		} 
		
		if ($_FILES['fichier_opml']['error'] !=  UPLOAD_ERR_OK  ){
			$this->sortirToParam("Erreur lors de l'import du fichier : ". $_FILES['fichier_opml']['error']);		
		}

		$opml_content = file_get_contents($_FILES['fichier_opml']['tmp_name']);
		$info = $this->OPMLReader->getInfo($opml_content);
		
		if(! $info){
			$this->sortirToParam($this->OPMLReader->getLastError());
		}		
		foreach($info as $feed){		
			$id_f = $this->FeedUpdater->addWithoutFetch($feed['xmlUrl']);
			if ($id_f){
				$this->AbonnementSQL->add($id_u,$id_f);
				foreach($feed['tag'] as $tag){
					$this->AbonnementSQL->addTag($id_u,$id_f,$tag);
				}
			}
		}

		$this->LastMessage->setLastMessage("Importation réussie");
		$this->redirect("/Param/index");
	}
	
	public function deleteAction(){
		$id_u = $this->verifConnected();
		
		$id = $this->Recuperateur->get('id');
		$code = $this->Recuperateur->get('code');
		
		if ($code != $id){
			$this->sortirToParam("Veuillez saisir l'identifiant du compte ($id)");	
		}
		
		$all_id_f = $this->AbonnementSQL->getAllId_f($id_u);
		foreach($all_id_f as $id_f){
			$this->FeedControler->deleteAbonnement($id_u,$id_f);
		}
		
		$this->UtilisateurSQL->delete($this->Connexion->getLogin());
		
		$this->Connexion->logout();
		$this->redirect();
		
	}
	
}
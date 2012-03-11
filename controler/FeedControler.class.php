<?php


class FeedControler extends ZenCancanControler {
	
	public function renderDefault($tag=""){
		
		$id_u = $this->Connexion->getId();	
		$info = $this->UtilisateurSQL->getInfo($id_u);
		$id = $info['id'];
		
		$this->addRSS("Votre flux zencancan",$this->Path->getPath("/RSS/all/$id"));
		if ($tag){
			$this->addRSS("Votre flux zencancan - $tag",$this->Path->getPath("/RSS/all/$id/$tag"));
		}		
		
		$this->Gabarit->tag = $tag;
		$this->Gabarit->add_site = true;
		parent::renderDefault();
	}
	
	public function listAction($offset = 0,$tag = false){		
		$offset = (int) $offset;
		if ($offset<0){
			$offset = 0;
		}
		$id_u = $this->verifConnected();
		
		$this->Gabarit->all_tag = $this->TagSQL->getAllTag($id_u);
		
		$this->Gabarit->allFlux = $this->AbonnementSQL->get($id_u,$tag,$offset);
		$this->Gabarit->nbFlux = $this->AbonnementSQL->getNbFlux($id_u,$tag);		
		$this->SuivantPrecedent->setParameter($offset,
												AbonnementSQL::NB_DISPLAY,
												$this->Gabarit->nbFlux ,
												$this->Path->getPath("/Feed/list/%d/$tag"));
		$this->Gabarit->template_milieu = "FluxList";
		$this->Gabarit->offset = $offset;
		$this->Gabarit->nbAfficher = AbonnementSQL::NB_DISPLAY;
		$this->renderDefault($tag);
	}
	
	public function forceReloadAction($id_f){
		$id_u = $this->verifConnected();
		if ($this->UtilisateurSQL->isAdmin($id_u)){
			$last_id = $this->FeedUpdater->forceUpdate($id_f);
			if ($last_id){
				$this->LastMessage->setLastMessage("Le flux a été rafraichi");
				$this->redirect("/Feed/Read/$last_id");
			}
		}
		$this->LastMessage->setLastError("Le flux n'a pas été rafraichi");
		$this->redirect("/Feed/Detail/$id_f");
	}
	
	public function updateAction($id_f){
		$id_u = $this->verifConnected();
		$info = $this->FeedSQL->getInfo($id_f);
		$nb_second_since_last_recup = time() - strtotime($info['last_maj']);
		
		if ($this->UtilisateurSQL->isAdmin($id_u) || $nb_second_since_last_recup > 360){
			$result = $this->FeedUpdater->update($id_f);			
			$this->LastMessage->setLastMessage("Le flux a été rafraichi ($result)");
			$info = $this->FeedSQL->getInfo($id_f);
		}
		$this->redirect2DetailOrRead($info);
	}
	
	
	public function doAddAction(){
		$id_u = $this->verifConnected();
		$url = $this->Recuperateur->get('url');
		$id_f = $this->FeedUpdater->add($url);

		if ($id_f){
			$this->AbonnementSQL->add($id_u,$id_f);
		} else {
			$this->LastMessage->setLastError($this->FeedUpdater->getLastError(),true);
			$this->ErrorSQL->add($url,$this->FeedUpdater->getLastError());
		} 	
		
		$abonnementInfo = $this->AbonnementSQL->getInfo($id_u,$id_f);
		$this->redirect2DetailOrRead($abonnementInfo);
		
	}
	
	private function verifAbonnement($id_u,$id_f){
		if ( ! $this->AbonnementSQL->isAbonner($id_u,$id_f)){
			if (! $this->UtilisateurSQL->isAdmin($id_u)){
				$this->redirect();
			}
		}
	}
	
	public function detailAction($id_f){
		$id_u = $this->verifConnected();
		$this->verifAbonnement($id_u,$id_f);
		
		$info = $this->FeedSQL->getInfo($id_f);
			
		if ($info && $info['last_id_i']){
			$this->redirect("/Feed/read/{$info['last_id_i']}");
		}
		
		$abonnementInfo = $this->AbonnementSQL->getInfo($id_u,$id_f);
		$abonnementInfo["nb_second_since_last_recup"] = time() - strtotime($abonnementInfo['last_recup']);
		
		$this->addRSS($abonnementInfo['title'],$abonnementInfo['url']);
		$this->Gabarit->abonnementInfo = $abonnementInfo;
		$this->Gabarit->allItem = array();
		$this->Gabarit->itemInfo = array();
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($abonnementInfo['tag']);
	}
	
	
	public function readAction($id_i){
		$id_u = $this->verifConnected();
		
		$itemInfo = $this->FeedItemSQL->getInfo($id_i);
		if (! $itemInfo){
			$this->redirect();
		}
		
		$id_f = $itemInfo['id_f'];
		$this->verifAbonnement($id_u,$id_f);
			
		$allItem = $this->FeedItemSQL->getAll($id_f);
		$abonnementInfo = $this->AbonnementSQL->getInfo($id_u,$id_f);
		$abonnementInfo["nb_second_since_last_recup"] = time() - strtotime($abonnementInfo['last_recup']);
		
		
		$this->addRSS($abonnementInfo['title'],$abonnementInfo['url']);
		$this->Gabarit->abonnementInfo = $abonnementInfo;
		$this->Gabarit->allItem = $allItem;
		$this->Gabarit->itemInfo = $itemInfo;
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($abonnementInfo['tag']);
		
	}
	
	public function doDeleteAction(){
		$id_u = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$this->deleteAbonnement($id_u, $id_f);
		$this->LastMessage->setLastMessage("Le suivie du site à été supprimé ");
		$this->redirect();
	}
	
	public function deleteAbonnement($id_u,$id_f){
		$this->AbonnementSQL->del($id_u,$id_f);
		if ($this->AbonnementSQL->getNbAbonner($id_f) == 0){
			$this->ImageUpdater->removeAllImage($id_f);
			$this->FeedItemSQL->deleteAll($id_f);
			$this->FeedSQL->del($id_f);
		}
	}
	
}
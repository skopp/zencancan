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
		
		if ($this->UtilisateurSQL->isAdmin($id_u)){
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
	
	public function getItem($rssInfo,$i){
		if (empty($rssInfo['item'][$i])){
			$this->LastMessage->setLastError("Cet article n'existe pas ou plus");
			$this->redirect();
		}
		$resultItem = $rssInfo['item'][$i];
		
		$content_html = $resultItem['content']?:$resultItem['description'];
		
		$this->HTMLPurifier->setBaseLink($rssInfo['link']);
		$content_html = $this->HTMLPurifier->purify($content_html);
		
		$resultItem['content'] = $content_html;
		
		return $resultItem;
	}
	
	public function detailAction($id_f){
		$id_u = $this->verifConnected();
		$this->verifAbonnement($id_u,$id_f);
		$abonnementInfo = $this->AbonnementSQL->getInfo($id_u,$id_f);
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
		
		$id_f = $itemInfo['id_f'];
		$this->verifAbonnement($id_u,$id_f);
			
		$allItem = $this->FeedItemSQL->getAll($id_f);
		
		
		$abonnementInfo = $this->AbonnementSQL->getInfo($id_u,$id_f);
		
		
		$this->addRSS($abonnementInfo['title'],$abonnementInfo['url']);
		$this->Gabarit->abonnementInfo = $abonnementInfo;
		$this->Gabarit->allItem = $allItem;
		$this->Gabarit->itemInfo = $itemInfo;
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($abonnementInfo['tag']);
		
	}
	
	public function doAddMurAction(){
		$id_u = $this->verifConnected();
		$id_i = $this->Recuperateur->getInt('id_i');
		
		$itemInfo = $this->FeedItemSQL->getInfo($id_i);
		$id_f = $itemInfo['id_f'];
		$this->verifAbonnement($id_u,$id_f);
		$feedInfo = $this->FeedSQL->getInfo($id_f);
		
		$img_name ='';
		if ($itemInfo['img']){
			$img_name = md5(mt_rand()).".png";
			copy($this->img_path.$itemInfo['img'],$this->img_path.$img_name);
		}
		
		$this->MurSQL->add($id_u,$itemInfo['content'],$feedInfo['title'] ." - " .$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$img_name);
		$mur_path = $this->Path->getPath("/Mur/index");
		$this->LastMessage->setLastMessage("L'article a été publié sur <a href='$mur_path'>votre mur</a>",true);
		$this->redirect("/Feed/read/$id_i");
	}
	
	
	public function doDeleteAction(){
		$id = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$this->AbonnementSQL->del($id,$id_f);
		$this->LastMessage->setLastMessage("Le suivie du site à été supprimé ");
		$this->redirect();
	}

	
	
}
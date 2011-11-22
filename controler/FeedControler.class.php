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
		$id = $this->verifConnected();
		if ($this->UtilisateurSQL->isAdmin($id)){
			$info = $this->AbonnementSQL->getInfo($id,$id_f);
			$r = $this->FeedUpdater->forceUpdate($id_f,$info['url']);
			$this->LastMessage->setLastMessage($r?"Flux rafraichi":"Flux non rafraichi");
		}
		$this->redirect("/Feed/detail/$id_f");
	}
	
	public function doAddAction(){
		$id = $this->verifConnected();
		$url = $this->Recuperateur->get('url');
		$id_f = $this->FeedUpdater->add($url);

		if ($id_f){
			$this->AbonnementSQL->add($id,$id_f);
		} else {
			$this->LastMessage->setLastError($this->FeedUpdater->getLastError(),true);
			$this->ErrorSQL->add($url,$this->FeedUpdater->getLastError());
		} 	
		$this->redirect("/Feed/detail/$id_f");
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

		$info = $this->AbonnementSQL->getInfo($id_u,$id_f);

		@ $content =  file_get_contents(STATIC_PATH."/$id_f");
		
		if (! $content){
			if ($this->FeedUpdater->forceUpdate($id_f,$info['url'])){
				$content = file_get_contents(STATIC_PATH."/$id_f");
			} 
		}

		if ($content){
			$rssInfo = $this->FeedParser->parseXMLContent($content);
		} else {
			$rssInfo = array('link' => $info['link'],'title' => $info['title'],'item' => array());
		}
		
		$this->addRSS($info['title'],$info['url']);
		
		$this->Gabarit->template_milieu = "FluxDetail";
		$this->Gabarit->rssInfo = $rssInfo;
		$this->Gabarit->content = $content;
		$this->Gabarit->id_f = $id_f;
		$this->Gabarit->info = $info;
		$this->renderDefault($info['tag']);
	}
	
	
	private function getFeedInfo($id_f){		
		$id_u = $this->verifConnected();
		$this->verifAbonnement($id_u,$id_f);

		$info = $this->AbonnementSQL->getInfo($id_u,$id_f);
			
		@ $content = file_get_contents(STATIC_PATH."/$id_f");
		
		if (! $content){
			if ($this->FeedUpdater->forceUpdate($id_f,$info['url'])){
				$content = file_get_contents(STATIC_PATH."/$id_f");
			} 
		}
		
		$rssInfo = $this->FeedParser->parseXMLContent($content);
		
		return $rssInfo;
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
	
	
	public function readAction($id_f,$i = 0){
		if (!$i){
			$i = 0;
		}
		$id_u = $this->verifConnected();
		$this->verifAbonnement($id_u,$id_f);
		
		$info = $this->AbonnementSQL->getInfo($id_u,$id_f);
		$this->addRSS($info['title'],$info['url']);
		
		$rssInfo = $this->getFeedInfo($id_f);
		
		
		$resultItem = $this->getItem($rssInfo,$i);
			
		$this->Gabarit->rejected_tag = $this->HTMLPurifier->getRejectedTag();
		$this->Gabarit->rejected_attributes = $this->HTMLPurifier->getRejectedAttributes();
		$this->Gabarit->rejected_style = $this->HTMLPurifier->getRejectedStyle();
		$this->Gabarit->content_html = $resultItem['content'];
		$this->Gabarit->resultItem = $resultItem;
		$this->Gabarit->selected_item = $i;
		$this->Gabarit->rssInfo = $rssInfo;
		$this->Gabarit->id_f = $id_f;
		$this->Gabarit->num_feed = $i;
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($info['tag']);
		
	}
	
	public function doAddMurAction(){
		$id_u = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$num_feed = $this->Recuperateur->getInt('num_feed');
		$rssInfo = $this->getFeedInfo($id_f);
		$resultItem = $this->getItem($rssInfo,$num_feed);
		$content = $resultItem['content'];
		$description = $resultItem['description'];
		$img = $this->ImageFinder->getFirst($resultItem['content']);
		$this->MurSQL->add($id_u,$content,$rssInfo['title'] ." - " .$resultItem['title'],$resultItem['link'],$description,$img);
		$mur_path = $this->Path->getPath("/Mur/index");
		$this->LastMessage->setLastMessage("L'article a été publié sur <a href='$mur_path'>votre mur</a>",true);
		$this->redirect("/Feed/read/$id_f/$num_feed");
	}
	
	
	public function doDeleteAction(){
		$id = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$this->AbonnementSQL->del($id,$id_f);
		$this->LastMessage->setLastMessage("Le suivie du site à été supprimé ");
		$this->redirect();
	}

	
	
}
<?php
class FeedControler extends ZenCancanControler {
	
	public function listAction($offset = 0,$tag = false){
		$offset = (int) $offset;
		if ($offset<0){
			$offset = 0;
		}
		$id = $this->verifConnected();
		
		$this->Gabarit->allFlux = $this->AbonnementSQL->get($id,$tag,$offset);
		$this->Gabarit->nbFlux = $this->AbonnementSQL->getNbFlux($id,$tag);	
		$this->Gabarit->template_milieu = "FluxList";
		$this->Gabarit->offset = $offset;
		$this->Gabarit->nbAfficher = AbonnementSQL::NB_DISPLAY;
		
		$this->renderDefault($tag);
	}
	
	public function forceReloadAction($id_f){
		$id = $this->verifConnected();
		if ($this->Compte->isAdmin($id)){
			$info = $this->AbonnementSQL->getInfo($id,$id_f);
			$r = $this->FeedUpdater->forceUpdate($id_f,$info['url']);
			$this->LastMessage->setLastMessage($r?"Flux rafraichi":"Flux non rafraichi");
		}
		$this->redirect("/Feed/detail/$id_f");
	}
	
	public function doAddAction(){
		$id = $this->verifConnected();
		$url = $this->Recuperateur->get('url');
		$tag = $this->Recuperateur->get('tag');

		$id_f = $this->FeedUpdater->add($url);

		if ($id_f){
			$this->AbonnementSQL->add($id,$id_f,$tag);
		} else {
			$this->LastMessage->setLastError($this->FeedUpdater->getLastError(),true);
			$this->ErrorSQL->add($url,$this->FeedUpdater->getLastError());
		} 	
		$this->redirect("/Feed/detail/$id_f");
	}
	
	public function detailAction($id_f){
		
		$id = $this->verifConnected();
		if ( ! $this->AbonnementSQL->isAbonner($id,$id_f)){
			header("Location: index.php?id=$id");
			exit;
		}

		$info = $this->AbonnementSQL->getInfo($id,$id_f);

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
	
	
	public function readAction($id_f,$i = 0){
		if (!$i){
			$i = 0;
		}
		$id = $this->verifConnected();
		if ( ! $this->AbonnementSQL->isAbonner($id,$id_f)){
			header("Location: index.php?id=$id");
			exit;
		}
		
		$info = $this->AbonnementSQL->getInfo($id,$id_f);
		
		@ $content = file_get_contents(STATIC_PATH."/$id_f");
		
		if (! $content){
			if ($this->FeedUpdater->forceUpdate($id_f,$info['url'])){
				$content = file_get_contents(STATIC_PATH."/$id_f");
			} 
		}
		
		
		$rssInfo = $this->FeedParser->parseXMLContent($content);
		
		$this->addRSS($info['title'],$info['url']);
		if (empty($rssInfo['item'][$i])){
			$this->LastMessage->setLastError("Cet article n'existe pas ou plus");
			$this->redirect();
		}
		
		$resultItem = $rssInfo['item'][$i];
		
		$content_html = $resultItem['content']?:$resultItem['description'];
		$content_html = $this->HTMLNormalizer->get($content_html,$rssInfo['link']);
		
		$this->Gabarit->rejected_tag = $this->HTMLPurifier->getRejectedTag();
		$this->Gabarit->rejected_attributes = $this->HTMLPurifier->getRejectedAttributes();
		
		$this->Gabarit->content_html = $content_html;
		$this->Gabarit->resultItem = $resultItem;
		$this->Gabarit->selected_item = $i;
		$this->Gabarit->rssInfo = $rssInfo;
		$this->Gabarit->id_f = $id_f;
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($info['tag']);
		
	}
	
	public function doDeleteAction(){
		$id = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$this->AbonnementSQL->del($id,$id_f);
		$this->LastMessage->setLastMessage("Le suivie du site à été supprimé ");
		$this->redirect();
	}
	
	public function doAggregateAction(){
		$id = $this->verifConnected();
		$id_f = $this->Recuperateur->getInt('id_f');
		$tag = $this->Recuperateur->get('tag');
		$this->AbonnementSQL->addTag($id,$id_f,$tag);
		if ($tag){
			$this->LastMessage->setLastMessage("Le flux est maintenant dans la catégorie $tag");
		} else {
			$this->LastMessage->setLastMessage("Le flux a été oté de la catégorie");
		}
		$this->redirect("/Feed/detail/$id_f");
		
	}
	
	
}
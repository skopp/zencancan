<?php
class FeedControler extends ZenCancanControler {
	
	public function listAction($id,$tag,$offset){
		
		$allFlux = $this->AbonnementSQL->get($id,$tag,$offset);
		$nbFlux = $this->AbonnementSQL->getNbFlux($id,$tag);
		
		$paginator = new Paginator($nbFlux,AbonnementSQL::NB_DISPLAY,$offset);
		$paginator->setLink("index.php?id=$id&tag=$tag");
		
	
		$this->Gabarit->allFlux = $allFlux;
		$this->Gabarit->nbFlux = $nbFlux;
		$this->Gabarit->paginator = $paginator;
		$this->Gabarit->revision_number = $this->revision_number;	
		$this->Gabarit->template_milieu = "FluxList";
		$this->renderDefault($id,$tag);
	}
	
	public function detailAction($id,$id_f){
		
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

		$this->Gabarit->template_milieu = "FluxDetail";
		$this->Gabarit->rssInfo = $rssInfo;
		$this->Gabarit->content = $content;
		$this->Gabarit->id_f = $id_f;
		$this->Gabarit->info = $info;
		$this->renderDefault($id,$info['tag']);
	}
	
	public function readAction($id,$id_f,$item){
		
		if ( ! $this->AbonnementSQL->isAbonner($id,$id_f)){
			header("Location: index.php?id=$id");
			exit;
		}
		
		$info = $this->AbonnementSQL->getInfo($id,$id_f);
		
		$content = file_get_contents(STATIC_PATH."/$id_f");
		$rssInfo = $this->FeedParser->parseXMLContent($content);
		
		//$pageHTML->addRSSURL($info['title'],$info['url']);
		
		
		foreach($rssInfo['item'] as $i => $itemInfo){
			if ($itemInfo['id_item'] == $item){
				$resultItem = $itemInfo;
				break;
			}
		}
		
		if (empty($resultItem)){
			$this->LastMessage->setLastError("Cet article n'existe pas ou plus");
			header("Location: feed.php?id=$id&id_f=$id_f");
			exit;
		}
		
		$content_html = $resultItem['content']?:$resultItem['description'];
		$content_html = $this->HTMLNormalizer->get($content_html,$rssInfo['link']);

		$this->Gabarit->content_html = $content_html;
		$this->Gabarit->resultItem = $resultItem;
		$this->Gabarit->rssInfo = $rssInfo;
		$this->Gabarit->id_f = $id_f;
		$this->Gabarit->template_milieu = "FluxRead";
		
		$this->renderDefault($id,$info['tag']);
		
	}
	
}
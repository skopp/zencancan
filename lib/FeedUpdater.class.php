<?php

class FeedUpdater {
	
	const MIN_TIME_BEETWEEN_LOAD = 360;
		
	private $feedSQL;
	private $feedFetchInfo;
	private $lastError;
	private $feedItemUpdater;
	
	public function __construct(FeedSQL $feedSQL,FeedFetchInfo $feedFetchInfo,FeedItemUpdater $feedItemUpdater){
		$this->feedSQL = $feedSQL;
		$this->feedFetchInfo = $feedFetchInfo;
		$this->feedItemUpdater = $feedItemUpdater;
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function addWithoutFetch($url){
		if (! $url){
			return;
		}
		$info = $this->feedSQL->getInfoFromURL($url);
		if ($info){
			return $info['id_f'];
		}
		$feedInfo = array();
		$feedInfo['lasterror'] = "";
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = "";
		$feedInfo['last-modified'] = date("1970-01-01");
		$feedInfo['id_item'] = "";
		$feedInfo['title'] = "En cours de récupération";
		$feedInfo['link'] = $url;
		$feedInfo['item_title'] = $url;
		$feedInfo['item_link'] =  $url;		
		$feedInfo['item_content'] = "";	
		$feedInfo['pubDate'] = date("Y-m-d H:i:s");
		$feedInfo['favicon'] = "";
		$feedInfo['item'] = array();
		$feedInfo['md5'] = 0;
		$id_f= $this->feedSQL->insert($feedInfo);
		$this->feedSQL->forceLastRecup($url);
		return $id_f;
	}
	
	public function add($url){
		
		if (! $url){
			 $this->lastError = "Aucune URL spécifiée";
			return false;
		}
		$info = $this->feedSQL->getInfoFromURL($url);
		if ($info){
			return $info['id_f'];
		}
		
		$feedInfo = $this->feedFetchInfo->getURL($url);
		
		if ( ! $feedInfo){
			$this->lastError = $this->feedFetchInfo->getLastError();
			return false;
		}
		
		$info = $this->feedSQL->getInfoFromURL($feedInfo['url']);
		if ($info){
			return $info['id_f'];
		}
		
		$feedInfo['md5'] = $this->getMD5($feedInfo);
		$this->feedSQL->insert($feedInfo);
		$info = $this->feedSQL->getInfoFromURL($feedInfo['url']);
		$this->feedItemUpdater->update($info['id_f'],$feedInfo);
		return $info['id_f'];
	}
	
	private function getMD5($feedInfo){
		unset($feedInfo['lastBuildDate']);
		unset($feedInfo['last-modified']);
		return md5(serialize($feedInfo));
	}
	
	public function update($id_f) {
		$info = $this->feedSQL->getInfo($id_f);		
		$feedInfo = $this->feedFetchInfo->updateURL($info['url'],$info['etag'],$info['last-modified']);
		
		if (! $feedInfo){
			$this->feedSQL->udpateLastRecup($info['url'],$this->feedFetchInfo->getLastError());
			return $this->feedFetchInfo->getLastError();
		}
		
		$md5 = $this->getMD5($feedInfo);
	
		if ($md5 == $info['md5']){
			$this->feedSQL->udpateLastRecup($info['url'],"md5 match");
			return "md5 match";
		}
		$this->updateSQL($id_f,$feedInfo);
		return $feedInfo['lasterror'];
	}
	
	public function forceUpdate($id_f){
		$info = $this->feedSQL->getInfo($id_f);
		$feedInfo = $this->feedFetchInfo->updateURL($info['url'],"","");	
		if ( ! $feedInfo){
			return false;
		}
		return $this->updateSQL($id_f,$feedInfo);
	}
	
	private function updateSQL($id_f,$feedInfo){
		$feedInfo['md5'] = $this->getMD5($feedInfo);		
		$this->feedSQL->update($id_f,$feedInfo);
		$this->feedItemUpdater->update($id_f,$feedInfo);
		$info = $this->feedSQL->getInfo($id_f);
		return $info['last_id_i'];
	}
	
	public function updateOnce(){
		$start = time();
		$all_id_f = $this->feedSQL->getAllToUpdate(self::MIN_TIME_BEETWEEN_LOAD);
		echo "Nombre de flux à mettre à jour : " . count($all_id_f). "\n";
		
		foreach($all_id_f as $info){
			$this->updateAFeed($info['id_f']);
		}
		$stop = time();
		$sleep = self::MIN_TIME_BEETWEEN_LOAD - ($stop -$start);
		if ($sleep > 0){
			echo "Arret du script : $sleep";
			sleep($sleep);
		}
	}
	
	private function updateAFeed($id_f){
		$info = $this->feedSQL->getInfo($id_f);
		echo "Récup de {$info['url']} - ";
		$lastError = $this->update($id_f);
		echo "OK {$lastError}\n";
	}
}
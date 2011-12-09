<?php

class FeedUpdater {
	
	const MIN_TIME_BEETWEEN_LOAD = 360;
		
	private $feedSQL;
	private $feedFetchInfo;
	private $lastError;
	private $favicon_path;
	private $feedItemUpdater;
	
	public function __construct(FeedSQL $feedSQL,FeedFetchInfo $feedFetchInfo,FeedItemUpdater $feedItemUpdater,$favicon_path){
		$this->feedSQL = $feedSQL;
		$this->feedFetchInfo = $feedFetchInfo;
		$this->favicon_path = $favicon_path;
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
		$feedInfo = $this->addImg($feedInfo);
		$this->feedSQL->insert($feedInfo);
		$info = $this->feedSQL->getInfoFromURL($feedInfo['url']);
		$this->feedItemUpdater->update($info['id_f'],$feedInfo);
		return $info['id_f'];
	}
	
	public function getFavicon($url){
		$parse = parse_url($url);
		$favicon = $parse['scheme'] . "://".$parse['host']."/favicon.ico";
		@ $content = file_get_contents($favicon);
		return $content;
	}
	
	
	public function addImg($feedInfo){
		$favicon = $this->getFavicon($feedInfo['url']);
		if ($favicon){
			$feedInfo['favicon'] = md5(mt_rand()) .".ico";
			file_put_contents($this->favicon_path . "/" . $feedInfo['favicon'],$favicon);
		} else {
			$feedInfo['favicon'] = "";
		}
		return $feedInfo;
	}
	
	public function removeImage($id_f){
		$info = $this->feedSQL->getInfo($id_f);
		if ($info['favicon']) {
			@ unlink($this->favicon_path . "/" . $info['favicon']);
		}
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
		$this->removeImage($id_f);
		$feedInfo['md5'] = $this->getMD5($feedInfo);
		$feedInfo = $this->addImg($feedInfo);
		
		$this->feedSQL->update($id_f,$feedInfo);
		
		$this->feedItemUpdater->update($id_f,$feedInfo);
		$info = $this->feedSQL->getInfo($id_f);
		return $info['last_id_i'];
	}
	
	public function updateForever(AbonnementSQL $abonnementSQL,$log_file){
		
		$info = $this->feedSQL->getFirstToUpdate();
		while (true) { 
			if (! $info){
				sleep(self::MIN_TIME_BEETWEEN_LOAD);
				continue;
			}
			
			$this->sleepIfNeeded($info['last_recup'],$log_file);
			
			$id_f = $info['id_f'];	
			
			if ($abonnementSQL->getNbAbonner($id_f) == 0){
				$this->feedSQL->del($id_f);
				file_put_contents($log_file,"Supression de {$info['url']}\n",FILE_APPEND);
			} else {
				file_put_contents($log_file,"Récup de {$info['url']} - ",FILE_APPEND);
				$lastError = $this->update($id_f);
				file_put_contents($log_file,"OK {$lastError}\n",FILE_APPEND);
			}
			
			$info = $this->feedSQL->getFirstToUpdate();
		}
	}
	
	private function sleepIfNeeded($lastRecup,$log_file){
		$timeToSleep =  self::MIN_TIME_BEETWEEN_LOAD - (time() - strtotime($lastRecup));
		if ( $timeToSleep > 0){
			file_put_contents($log_file,"Je m'endors pendant $timeToSleep s\n",FILE_APPEND);
			sleep( $timeToSleep);
		}
	}
}
<?php

require_once("FeedParser.class.php");
require_once("URLLoader.class.php");
require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");

class FeedUpdater {
	
	const MIN_TIME_BEETWEEN_LOAD = 360;
	
	private $feedSQL;
	private $feedFetchInfo;
	private $staticPath;
	
	private $lastError;
	
	public function __construct(FeedSQL $feedSQL,FeedFetchInfo $feedFetchInfo,$staticPath){
		$this->feedSQL = $feedSQL;
		$this->feedFetchInfo = $feedFetchInfo;
		
		
		$this->staticPath = $staticPath;
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function addWithoutFetch($url){
		if (! $url){
			return;
		}
		$info = $this->feedSQL->getInfo($url);
		if ($info){
			return $info['id_f'];
		}
		$feedInfo = array();
		$feedInfo['lasterror'] = "";
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = "";
		$feedInfo['last-modified'] = date("1970-01-01");
		$feedInfo['id_item'] = "";
		$feedInfo['title'] = "En cours de r&eacute;cup&eacute;ration";
		$feedInfo['link'] = $url;
		$feedInfo['item_title'] = $url;
		$feedInfo['item_link'] =  $url;		
		$feedInfo['item_content'] = "";	
		$feedInfo['pubDate'] = date("Y-m-d H:i:s");
		$id_f= $this->feedSQL->insert($feedInfo);
		$this->feedSQL->forceLastRecup($url);
		return $id_f;
	}
	
	public function add($url){
		
		if (! $url){
			 $this->lastError = "Aucune URL sp&eacute;cifi&eacute;";
			return false;
		}
		$info = $this->feedSQL->getInfo($url);
		if ($info){
			return $info['id_f'];
		}
		
		$feedInfo = $this->feedFetchInfo->getURL($url);
		
		if ( ! $feedInfo){
			$this->lastError = $this->feedFetchInfo->getLastError();
			return false;
		}
		if ($url != $feedInfo['url']){
			$info = $this->feedSQL->getInfo($feedInfo['url']);
			if ($info){
				$this->feedSQL->doUpdate($info['id_f'],$feedInfo);
				$this->updateFile($info['id_f'],$this->feedFetchInfo->getLastContent());
				return $info['id_f'];
			}
		}
		
		$id_f = $this->feedSQL->insert($feedInfo);
		$this->updateFile($id_f,$this->feedFetchInfo->getLastContent());
		return $id_f;
	}
	
	public function update($url , $info ) {		
		$feedInfo = $this->feedFetchInfo->updateURL($url,$info['etag'],$info['last-modified']);
		if (! $feedInfo){
			$this->feedSQL->udpateLastRecup($url,$this->feedFetchInfo->getLastError());
			return $this->feedFetchInfo->getLastError();
		}
		$this->feedSQL->doUpdate($info['id_f'] , $feedInfo);
		$this->updateFile($info['id_f'] ,$this->feedFetchInfo->getLastContent());
		return $feedInfo['lasterror'];
	}
	
	public function updateForever($abonnementSQL,$log_file){
		
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
				$lastError = $this->update($info['url'],$info);
				file_put_contents($log_file,"R&eacute;cup de {$info['url']} - {$lastError}\n",FILE_APPEND);
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
	
	private function updateFile($id_f,$content){
		file_put_contents($this->staticPath."/".$id_f,$content);
	}
	
}
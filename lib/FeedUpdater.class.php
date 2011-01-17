<?php

require_once("FeedParser.class.php");
require_once("URLLoader.class.php");
require_once("FeedSQL.class.php");
require_once("AbonnementSQL.class.php");

class FeedUpdater {
	
	const MIN_TIME_BEETWEEN_LOAD = 360;
	
	private $feedSQL;
	private $staticPath;
	
	public function __construct(FeedSQL $feedSQL,$staticPath){
		$this->feedSQL = $feedSQL;
		$this->urlLoader = new URLLoader();
		$this->feedParser = new FeedParser();
		$this->staticPath = $staticPath;
		
	}
	
	private $lastError;
	
	public function getLastError(){
		return $this->lastError;
	}
	
	
	public function addWithoutFetch($url){
		$info = $this->feedSQL->getInfo($url);
		if ($info){
			return $info['id_f'];
		}
		$feedInfo = array();
		$feedInfo['lasterror'] = "";
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = "";
		$feedInfo['last-modified'] = "";
		$feedInfo['id_item'] = "";
		$feedInfo['title'] = "En cours de récupération";
		$feedInfo['link'] = $url;
		$feedInfo['item_title'] = $url;
		$feedInfo['item_link'] =  $url;		
		$feedInfo['item_content'] = "";	
		$feedInfo['pubDate'] = "";
		$id_f= $this->feedSQL->insert($feedInfo);
		$this->feedSQL->forceLastRecup($url);
		return $id_f;
	}
	
	//On ajoute une URL
	public function add($url){
		
		if (! $url){
			 $this->lastError = "Aucune URL spécifié";
			return false;
		}
		
		$info = $this->feedSQL->getInfo($url);
		if ($info){
			return $info['id_f'];
		}
		$content = $this->urlLoader->getContent($url);
		if ( ! $content ){
			
			
			$google = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".urlencode($url);
			
			if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
				$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3';
			}
			
			$result = $this->urlLoader->getContent($google,false,false,$_SERVER['HTTP_ACCEPT_LANGUAGE']);
			
			$result = json_decode($result,true);
			
			
			if (empty($result['responseData']['results'][0]['url'])){
				$this->lastError = "Je n'ai rien trouvé de tel";
				return false;
			}
			$url = $result['responseData']['results'][0]['url'];
			//$urlToGrab =  $result['responseData']['results'][0]['cacheUrl'];
			
			
			$content = $this->urlLoader->getContent($url);
			if (! $content){
				$this->lastError = "J'ai essayé $url ";
				return false;
			}
			
		}
		
		$finfo = new finfo(FILEINFO_MIME);
		$contentType  = $finfo->buffer($content);
		
		if (strstr($contentType,'text/html') !== false){
			$url_fromHTML =  $this->findFromHTML($url,$content);	
			
			if ($url_fromHTML){
				$url = $url_fromHTML;
				$content = $this->urlLoader->getContent($url);
				$contentType  = $finfo->buffer($content);
				
				$info = $this->feedSQL->getInfo($url);
				if ($info){
					return $info['id_f'];
				}
				
			} else {	
				$this->lastError = "$url ne permet pas qu'on le suive";
				return false;
			}
		} 
		
		if (strstr($contentType,'application/xml') === false){
			$this->lastError = "$url ne permet pas qu'on le suive ($contentType)";
			return false;
		}
		
		
		$feedInfo = $this->feedParser->getInfo($content);
		
		if ( ! $feedInfo){
			$this->lastError = $this->feedParser->getLastError();
			return false;
		}
			
		$feedInfo['lasterror'] = "";
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = $this->urlLoader->getHeader('etag');
		$feedInfo['last-modified'] = $this->urlLoader->getHeader('last-modified');
	
		$id_f = $this->feedSQL->insert($feedInfo);
		$this->updateFile($id_f,$content);
		return $id_f;
	}
	
	
	//On met à jour une URL : on est sur qu'elle existe;
	public function update($url , $info ) {		
	
		$content = $this->urlLoader->getContent($url,$info['etag'],$info['last-modified']);
		if (! $content ){
			$this->feedSQL->udpateLastRecup($url,$this->urlLoader->getLastError());
			return $this->urlLoader->getLastError();
		}
		
		$feedInfo = $this->feedParser->getInfo($content);
		$feedInfo['lasterror'] = $this->feedParser->getLastError();
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = $this->urlLoader->getHeader('etag');
		$feedInfo['last-modified'] = $this->urlLoader->getHeader('last-modified');
	
		$this->feedSQL->doUpdate($info['id_f'] , $feedInfo);
		$this->updateFile($info['id_f'] ,$content);
		return $feedInfo['lasterror'];
	}
	
	public function updateForever($abonnementSQL){
		
		$info = $this->feedSQL->getFirstToUpdate();
		
		while (true) { 
			if (! $info){
				sleep(self::MIN_TIME_BEETWEEN_LOAD);
				continue;
			}
			
			$this->sleepIfNeeded($info['last_recup']);
			
			$id_f = $info['id_f'];	
			
			if ($abonnementSQL->getNbAbonner($id_f) == 0){
				$this->feedSQL->del($id_f);
				echo "Supression de {$info['url']}\n";
			} else {
				$lastError = $this->update($info['url'],$info);
				echo "Récup de {$info['url']} - {$lastError}\n";
			}
			
			$info = $this->feedSQL->getFirstToUpdate();
		}
	}
	
	private function sleepIfNeeded($lastRecup){
			
		$timeToSleep =  self::MIN_TIME_BEETWEEN_LOAD - (time() - strtotime($lastRecup));
		if ( $timeToSleep > 0){
			echo "Je m'endors pendant $timeToSleep s\n";
			sleep( $timeToSleep);
		}
	}
	
	private function findFromHTML($base_url,$content){
		$dom = new DOMDocument();
		$dom->loadHTML($content);
		
		$url = "";
		$elementNode = $dom->getElementsByTagName("link");
		foreach($elementNode as $e){
			if (in_array($e->getAttribute("type") ,  array("application/rss+xml",'application/atom+xml') ) ){
				$url =  $e->getAttribute("href");
				break;
			}
				
		}
		if (! $url){
			return false;
		}
		if (preg_match("#https?://#",$url)){
			return $url;
		}
		if (! preg_match("#^/#",$url)){
			return $base_url."/".$url;
		}
		
		$parse = parse_url($base_url);
		$parse['path'] = $url;
		
		$url = $parse["scheme"]."://".$parse['host'].$url;
		return $url;
		
	}
	
	private function updateFile($id_f,$content){
		file_put_contents($this->staticPath."/".$id_f,$content);
	}
	
}
<?php
require_once("URLLoader.class.php");
require_once("FeedParser.class.php");
require_once("GoogleSearch.class.php");

class FeedFetchInfo {
	
	private $lastError;
	private $lastContent;
	
	private $urlLoader;
	private $feedParser;
	private $googleSearch;
	
	public function __construct(URLLoader $urlLoader, FeedParser $feedParser, GoogleSearch $googleSearch){
		$this->urlLoader = $urlLoader;
		$this->feedParser = $feedParser;
		$this->googleSearch = $googleSearch;
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function getLastContent(){
		return $this->lastContent;
	}
	
	public function updateURL($url,$etag,$lastModified){
		$this->lastContent = $this->urlLoader->getContent($url,$etag,$lastModified);
		
		if (! $this->lastContent ){
			$this->lastError = $this->urlLoader->getLastError() ;
			return false;
		}
		
		$feedInfo = $this->feedParser->getInfo($this->lastContent );
		
		if (! $feedInfo){
			$this->lastError = $this->feedParser->getLastError();
			return false;
		}
		$feedInfo['lasterror'] = $this->feedParser->getLastError();
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = $this->urlLoader->getHeader('etag');
		$feedInfo['last-modified'] = $this->urlLoader->getHeader('last-modified');
		return $feedInfo;
	}
	
	public function getURL($keyword_or_url){	
		$url = $keyword_or_url;
		$this->lastContent = $this->urlLoader->getContent($keyword_or_url);
		if (! $this->lastContent){
			$url = $this->googleSearch->get($keyword_or_url);
			if (! $url){
				$this->lastError = "Je n'ai rien trouvé correspondant à: $keyword_or_url";
				return false;
			}
			$this->lastContent = $this->urlLoader->getContent($url);
			if (! $this->lastContent){
				$this->lastError = "Le site <a href='$url'>$keyword_or_url</a> ne répond pas (".$this->urlLoader->getLastError().")";
				return false;
			}
		}
		$result = $this->feedParser->getInfo($this->lastContent);
		
		if ( ! $result ){
			$new_url =  $this->findFromHTML($url,$this->lastContent);	
			if ( ! $new_url){
				$this->lastError = "Le site <a href='$url'>$keyword_or_url</a> ne donne aucune information de suivi";
				return false;
			}
			$this->lastContent = $this->urlLoader->getContent($new_url);
			if (! $this->lastContent){
				$this->lastError = "Le site <a href='$url'>$keyword_or_url</a> ne répond pas" . 
					"(Page $new_url inaccessible - ".$this->urlLoader->getLastError().")";
				return false;
			}
			$result = $this->feedParser->getInfo($this->lastContent);
			if ( ! $result ){
				$this->lastError = "Les informations de suivi du site <a href='$url'>$keyword_or_url</a> ne sont pas utilisables";
				return false;
			}
			$url = $new_url;
		}
		
		
		$result['url'] = $url;
		$result['lasterror'] = "";
		$result['etag'] = $this->urlLoader->getHeader('etag');
		$result['last-modified'] = $this->urlLoader->getHeader('last-modified');
		return $result;
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
		
		if (empty($parse["scheme"])){
			$parse["scheme"] = "http";
		}
		if (empty($parse["host"])){
			$parse["host"] = $base_url;
		}
		$parse['path'] = $url;
		
		$url = $parse["scheme"]."://".$parse['host'].$url;
		return $url;
	}

	
}
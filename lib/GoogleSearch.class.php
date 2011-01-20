<?php
require_once("URLLoader.class.php");

class GoogleSearch {
	
	const SEARCH_URL = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=%s";
	const DEFAULT_HTTP_ACCEPT_LANGUAGE = 'fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3';
	
	private $urlLoader;
	private $httpAcceptLanguage;
	
	public function __construct(URLLoader $urlLoader){
		$this->urlLoader = $urlLoader;
		$this->setHTTPAcceptLanguage(self::DEFAULT_HTTP_ACCEPT_LANGUAGE);
	}
	
	public function setHTTPAcceptLanguage($httpAcceptLanguage){
		$this->httpAcceptLanguage = $httpAcceptLanguage;
	}

	public function get($keyword){
		$url = sprintf(self::SEARCH_URL,urlencode($keyword));
		$result = $this->urlLoader->getContent($url,false,false,$this->httpAcceptLanguage);
		if ( ! $result){
			return false;
		}
		
		$result = json_decode($result,true);
			
		if (empty($result['responseData']['results'][0]['url'])){
				return false;
		}
		return $result['responseData']['results'][0]['url'];
	}
	
}
<?php

class FeedLoader {
	
	private $timeout;	
	private $lastError;
	
	public function __construct($timeout = 5){
		$this->timeout = $timeout;
		libxml_use_internal_errors(true);
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function get($url){
				
		if (!$url){
			return false;
		}
	
		if (! filter_var($url,FILTER_VALIDATE_URL) ){
			$this->lastError = "L'url spécifié n'est pas valide";
		}
		
		$content = $this->getContent($url);
		if (! $content ){
			return false;
		}
		
		$xml = simplexml_load_string($content);
		if (! $xml ){
			$this->lastError = "L'adresse n'est pas un flux RSS";
			return false;
		}
		
		$feed = $this->parse($xml);
		if (! $feed ){
			$this->lastError = "L'adresse n'est pas un flux RSS";
			return false; 
		}
		return $feed;
		
	}

	private function getContent($url){
		
		$curl = curl_init($url);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl,CURLOPT_TIMEOUT,$this->timeout);
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );		
		
		$result =  curl_exec($curl);
		
		if ($result === false){
			$this->lastError = curl_error($curl);		
			return false;
		}
		
		$response = curl_getinfo($curl);				
					
		if ($response['http_code'] != 200){
			$this->lastError = "Erreur " . $response['http_code'];
			return false;
		}
		return $result; 				
	}
	
	private function parse(SimpleXMLElement $xml){		
		$documentType = strtolower($xml->getName());
		
		switch($documentType){
			case 'rss': return $this->parseRSS($xml);
			case 'rdf' : return $this->parseRDF($xml);
			case 'feed' : return $this->parseAtom($xml);
		}
		return false;
	}
	
	private function parseRSS($xml){
		return $this->parseRDForRSS($xml,$xml->channel->item);
	}
	
	private function parseRDF($xml){
		return $this->parseRDForRSS($xml,$xml->item);
	}
	
	private function parseRDForRSS($xml,$itemElement){
		$result = array();
		$result['title'] = strval($xml->channel->title);
		$result['link'] = $this->getRSSLink($xml->channel->link);
		$result['item'] = $this->getRSSItem($itemElement,$xml->getNamespaces(true));
		return $result;
	}
	
	private function getRSSLink($xmlNode){
		foreach($xmlNode as $link){
			if ($link['rel']=="self"){
				continue;
			}
			return strval($link);
		}
	}
	
	private function getRSSItem($xmlItem, $ns){
		$items = array();
		
		foreach($xmlItem as $item){
			$it = array();
			$it['title'] = strval($item->title);
			$it['link'] = strval($item->link);
			$it['description'] = strval($item->description);
						
			$it['content'] = strval($item->content);	
			if (empty($it['content'])){				
				if (isset($ns["content"])){
					$content = $item->children($ns["content"]);
					$it['content'] = strval(trim($content->encoded));
				}
			}
						
			if ($item->pubDate){
				$it['pubDate'] = date("Y-m-d H:i:s",strtotime($item->pubDate));
			} else {
				if (isset($ns["dc"])){
					$pubDate = $item->children($ns["dc"]);
					$it['pubDate'] = date("Y-m-d H:i:s",strtotime($pubDate->date));
				} else { 
					$it['pubDate'] = date("Y-m-d H:i:s");
				}
			}
			
			if ($item->guid){
				$it['id_item'] = strval($item->guid);	
			} else {
				$it['id_item'] = strval($item->link);
			}						
			$items[]=$it;			
		}
		return $items;
  	}	
	
	private function parseAtom($xml){
		$result = array();
		$result['title'] = strval($xml->title);
		$result['link'] = $this->getOneLink($xml->link);
		$result['item'] = $this->getAtomItem($xml->entry);
		return $result;
	}
	
	private function getOneLink($links){		
		$result = false;
		foreach( $links as $link){
			if ($link['rel'] == 'alternate'){
				$result=  $link['href'];
			}
		}
		if (!$result) {
			$result = $links['href']; 
		}
		return strval($result);	 
	}
	
	public function getAtomItem(SimpleXMLElement $xml) {
		$items = array();
		foreach($xml as $item){
			$it = array();
			$it['title'] = strval($item->title);
			if (! $it['title']){
				$it['title'] = '(aucun sujet)';
			}
			$it['link'] = $this->getOneLink($item->link);						
			$it['description'] = strval($item->summary);
			$it['content'] = $this->getAtomItemContent($item->content);			
			if ($item->published){
				$date = $item->published; 							
			} else if ($item->updated){
				$date = $item->updated; 											
			} else {
				$date = date("Y-m-d H:i:s");
			}
			$it['pubDate'] = date("Y-m-d H:i:s",strtotime($date)); 	
			$it['id_item'] = strval($item->id);				
			$items[]=$it;
		}

		return $items;
  	}
  	
  	private function getAtomItemContent(SimpleXMLElement $contentNode){
		$result = "";
		if (!$contentNode){
  			return $result;
  		}
  		//BOF
 		if (strval($contentNode)){
 			return strval($contentNode);
 		}
		foreach($contentNode->children() as $child){
			$result .= $child->asXML();		
		}  		
		return $result;
  	}
}
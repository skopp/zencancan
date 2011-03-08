<?php


class FeedParser {
	
	private $timeout;	
	private $lastError;
	private $lastHeader;
	
	public function __construct(){
		libxml_use_internal_errors(true);
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function getInfo($content){
		$feedInfo = $this->parseXMLContent($content);
		if (! $feedInfo ){
			return false;
		}
		
		if (count($feedInfo['item'])){
			$feedInfo['pubDate'] = $feedInfo['item'][0]['pubDate'];
			$feedInfo['id_item'] = $feedInfo['item'][0]['id_item'];
			$feedInfo['item_title'] =  $feedInfo['item'][0]['title'];
			$feedInfo['item_link'] =  $feedInfo['item'][0]['link'];		
			$feedInfo['item_content'] =  $feedInfo['item'][0]['content'];	
			if (! $feedInfo['item_content']){
				$feedInfo['item_content'] =  $feedInfo['item'][0]['description'];
			}
		} else {
			$feedInfo['id_item'] = "";
			$feedInfo['item_title'] = "";
			$feedInfo['item_link'] =  "";		
			$feedInfo['item_content'] = "";	
			$feedInfo['pubDate'] = date("Y-m-d H:i:s");
		}
		unset($feedInfo['item']);
		return $feedInfo;
	}
	
	
	public function parseXMLContent($content){
		
		$xml = simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);
		
		
		if (! $xml ){
			$this->lastError = "L'adresse n'est pas un flux RSS (load)";
			return false;
		}
		
		$feed = $this->parse($xml);
		if (! $feed ){
			$this->lastError = "L'adresse n'est pas un flux RSS (parse)";
			return false; 
		}
	
		$this->lastError = "";
		return $feed;
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
		$result['title'] = $this->normalizeText($xml->channel->title);
		$result['link'] = $this->getRSSLink($xml->channel->link);
		$result['item'] = $this->getRSSItem($itemElement,$xml->getNamespaces(true));
		$result['lastBuildDate'] = strval(date("Y-m-d H:i:s",strtotime($xml->channel->lastBuildDate)));
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
			$it['title'] = $this->normalizeText(strval($item->title));
			$it['link'] = strval($item->link);
			$it['description'] = $this->normalizeText(strval($item->description));
						
			$it['content'] = $this->normalizeText(strval($item->content));	
			if (empty($it['content'])){				
				if (isset($ns["content"])){
					$content = $item->children($ns["content"]);
					$it['content'] = $this->normalizeText(strval(trim($content->encoded)));
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
			
			$it['id_item'] = "";
			if ($item->guid){
				$it['id_item'] = trim(strval($item->guid));	
			} 
			
			if (! $it['id_item']) {
				$it['id_item'] = strval($item->link);
			}						
			$items[]=$it;			
		}
		return $items;
  	}	
	
	private function parseAtom($xml){
		$result = array();
		$result['title'] = $this->normalizeText(strval($xml->title));
		$result['link'] = $this->getOneLink($xml->link);
		$result['item'] = $this->getAtomItem($xml->entry);
		$result['lastBuildDate'] = date("Y-m-d H:i:s",strtotime(strval($xml->lastBuildDate)));
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
			$it['title'] = $this->normalizeText($item->title);
			if (! $it['title']){
				$it['title'] = '(aucun sujet)';
			}
			$it['link'] = $this->getOneLink($item->link);						
			$it['description'] = $this->normalizeText($item->summary);
			$it['content'] = $this->getAtomItemContent($item->content);			
			if ($item->published){
				$date = $item->published; 							
			} else if ($item->updated){
				$date = $item->updated; 											
			} else {
				$date = date("Y-m-d H:i:s");
			}
			$it['pubDate'] = date("Y-m-d H:i:s",strtotime($date)); 	
			$it['id_item'] = strval($item->id) ;				
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
 			return $this->normalizeText($contentNode);
 		}
		foreach($contentNode->children() as $child){
			$result .= $child->asXML();		
		}  		
		return $this->normalizeText($result);
  	}
  	
  	private function normalizeText($text){
  		//copier/coller depuis MS Word ...
  		$text = str_replace("?", "'",$text);
  		
  		return strval($text);
  		//return html_entity_decode(strval($text),ENT_QUOTES,"UTF-8");
  	}
  	
}
<?php
class HTMLPurifier {
	
	private $lastError;
	
	private $baseLink;
	private $allowTag;
	private $allowAttr;
	
	private $rejectedTag = array();
	private $rejectedAttributes = array();
	
	private $domDocument;
	
	public function __construct(){
		$this->allowTag = array(
						"#text","p","span","em","a",
						"img","br","ul","li",
						"h2","h3","h4","h5","h6",
						"strong","del","ol","div","sup","pre","code","blockquote",
						"table","tr","td",
						"abbr","hr","small",
						"col",
		
						);
		$this->allowAttr = array(
				"a" => array("href","hreflang","title"),
				"img" => array("src","alt","title","width","height","border","ismap"),
				"plusone" => array("size","count"),
				"table" => array("border"),
				"td" => array("valign","colspan"),
				"tr" => array("valign","colspan"),
				"abbr" => array("title"),
		);
	}
	
	public function setBaseLink($baseLink){
		$this->baseLink = $baseLink;
	}
	
	public function getRejectedTag(){
		return array_keys($this->rejectedTag);
	}
	
	public function getRejectedAttributes(){
		return array_keys($this->rejectedAttributes);
	}
	
	public function purify($data){		
		$data = preg_replace("#&#","&amp;",$data);
		$data = preg_replace("#<g:plusone#","<plusone",$data);
		$data = preg_replace("#</g:plusone#","</plusone",$data);
		
		$data = "<document>$data</document>";
		
		$domDocument = new DomDocument();
		if (! @ $domDocument->loadXML($data)){
			@ $domDocument->loadHTML('<?xml encoding="UTF-8">'.$data);
			/*echo $data;
			exit;
			/*echo $data;
			exit;
			$errors = libxml_get_last_error();
			$this->lastError = "Oops... le document n'a pas pu être analysé : ".($errors->message);
			trigger_error($this->lastError);
			return "<p>" . $this->lastError . "</p>" . htmlentities($data,ENT_QUOTES,"UTF-8");*/
		}
			
		$body = $domDocument->getElementsByTagName("document");		
		$body = $body->item(0);
		$this->purifyNode($body,$domDocument);
		
		$result = "";
		foreach($body->childNodes as $child){
			$result .= $domDocument->saveXML($child);
		}
		
		$result = preg_replace("#&amp;#","&",$result);
		return $result;	
	}
	
	private function purifyNode(DomNode $node,DomDocument $domDocument){
		$to_remove = array();		
		$to_erase = array();
		foreach($node->childNodes  as $child){
			if ($child instanceof DOMElement){
				$this->purifyAttribut($child);
				$this->purifyNode($child,$domDocument);
			
				if (! in_array($child->nodeName,$this->allowTag)){
					$this->rejectedTag[$child->nodeName] = true;
					$to_remove[] = $child;
				}
			} elseif (! $child instanceof DOMText){
				$to_erase[] = $child;
			}
		}
	
		foreach($to_erase as $child){
			$node->removeChild($child);
		}
		foreach($to_remove as $child){
			$this->remonterNode($node,$child,$domDocument);			
		}
		
	}
	
	public function remonterNode(DOMElement $node,DomElement $child,DomDocument $domDocument){
		$beginNode = $domDocument->createComment("tag removed :" . $child->nodeName );
		$node->insertBefore($beginNode,$child);
		
		if ($child->hasChildNodes() ){
			$tab = $child->childNodes;
			foreach($tab as $small_child){
				$sampleNode = $small_child->cloneNode(true);
				$node->insertBefore($sampleNode,$child);
			}
		}
		$endNode = $domDocument->createComment("end tag removed " . $child->nodeName );
		$node->replaceChild($endNode,$child);	
	}
	
	
	public function purifyAttribut(DOMElement $node){		
		$attr2remove = array();
		foreach ($node->attributes as $name => $value) {
			if (isset($this->allowAttr[$node->nodeName])){
				if (in_array($name,$this->allowAttr[$node->nodeName])){
					continue;
				}
			}
			$attr2remove[] = $name;
		}
		foreach($attr2remove as $name){
			$node->removeAttribute($name);
			$this->rejectedAttributes["{$node->nodeName}->$name"] = true;
		}
		return $node;
	}
	
		
}


 
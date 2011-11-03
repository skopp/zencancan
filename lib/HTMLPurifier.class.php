<?php
class HTMLPurifier {
	
	private $baseLink;
	private $allowTag;
	
	private $rejectedTag = array();
	private $rejectedAttributes = array();
	
	private $domDocument;
	
	public function __construct(){
		$this->allowTag = array("#text","p","span","em","a","img","br","iframe");
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
		
		$data = "<?xml encoding='UTF-8'>$data";
		
		$domDocument = new DomDocument();
		$domDocument->loadHTML($data);
		$body = $domDocument->getElementsByTagName("body")->item(0);
		$this->purifyNode($body,$domDocument);
		
		
		$simple = simplexml_import_dom($domDocument);
		$data = "";
		foreach($simple->body->children() as $s){
			$data .= $s->asXML();	
		}
			
		return $data;
	}
	
	
	private function purifyNode(DomNode $node,DomDocument $domDocument){
		$to_remove = array();
		
		
		foreach($node->childNodes  as $child){
			if ($child instanceof DOMElement){
				$this->purifyAttribut($child);
				$this->purifyNode($child,$domDocument);
			}
			if (! in_array($child->nodeName,$this->allowTag)){
				$this->rejectedTag[$child->nodeName] = true;
				$to_remove[] = $child;
			}
		}
		foreach($to_remove as $child){
			$this->remonterNode($node,$child,$domDocument);
		}
		
	}
	
	public function remonterNode(DOMElement $node,DOMElement $child,DomDocument $domDocument){
		$beginNode = $domDocument->createTextNode("<" . $child->nodeName . ">");
		$node->insertBefore($beginNode,$child);
		
		if ($child->hasChildNodes() ){
			$tab = $child->childNodes;
			foreach($tab as $small_child){
				$sampleNode = $small_child->cloneNode();
				$node->insertBefore($sampleNode,$child);
			}
		}
		$endNode = $domDocument->createTextNode("</" . $child->nodeName . ">");
		$node->replaceChild($endNode,$child);
	
		
	}
	
	
	public function purifyAttribut(DOMElement $node){		
		foreach ($node->attributes as $name => $value) {
			$this->rejectedAttributes["{$node->nodeName}->$name"] = true; 
   			 $node->removeAttribute($name);
		}
		return $node;
	}
	
		
}


 
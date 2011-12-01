<?php
class HTMLPurifier {
	
	private $lastError;
	
	private $baseLink;
	private $allowTag;
	private $allowAttr;
	private $emptyTagToSupress;
	
	private $rejectedTag = array();
	private $rejectedAttributes = array();
	private $rejectedStyle = array();
	
	private $domDocument;
	
	public function __construct(){
		$this->allowTag = array(
						"#text","p","span","em","a",
						"img","br","ul","li",
						"h2","h3","h4","h5","h6",
						"strong","del","ol","div","sup","pre","code","blockquote",
						"table","tr","td",
						"abbr","hr","small",
						"col","b","i",
		
						);
		$this->allowAttr = array(
				"a" => array("href","hreflang","title","style"),
				"img" => array("src","alt","title","width","height","border"),
				"plusone" => array("size","count"),
				"table" => array("border"),
				"td" => array("valign","colspan"),
				"tr" => array("valign","colspan"),
				"abbr" => array("title"),
				"hr" => array("noshade","style"),
				"p" => array("align","style"),
				"span" => array("style"),
				"div" => array("style"),
		);
		
		$this->allowStyle = array("text-align", "margin-left", 
			"margin-right", "color", "font-size","font-weight"
			,"background-color", "line-height", "font-family", 
			"margin", "height", "padding", "background", "border", "font", "float", "width", "text-decoration",
			"font-style", "font-variant", "vertical-align",  
		);
		
		
		$this->emptyTagToSupress = array("p","span","div","pre","em","strong","h2","h3","h4","h5","h6");
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
	
	public function getRejectedStyle(){
		return array_keys($this->rejectedStyle);
	}
	
	public function purify($data){		
		$data = preg_replace("#&#","&amp;",$data);
		$data = preg_replace("#<g:plusone#","<plusone",$data);
		$data = preg_replace("#</g:plusone#","</plusone",$data);
		
		$data = "<document>$data</document>";
		
		$domDocument = new DomDocument();
		if (! @ $domDocument->loadXML($data)){
			@ $domDocument->loadHTML('<?xml encoding="UTF-8">'.$data);
		}
			
		$body = $domDocument->getElementsByTagName("document");		
		$body = $body->item(0);
		$this->purifyNode($body,$domDocument);
		$this->fixImg($domDocument);
		$this->fixEmptyTag($domDocument);
		$this->fixLink($domDocument);
		$result = "";
		foreach($body->childNodes as $child){
			$result .= $domDocument->saveXML($child);
		}
		
		$result = preg_replace("#&amp;#","&",$result);
		return $result;	
	}
	
	private function fixLink(DomDocument $domDocument){
		foreach($domDocument->getElementsByTagName('a') as $element) {
			$this->fixSrc($element,"href");
			$element->setAttribute('target',"_blank");
		}
	}
	
	private function fixSrc(DomNode $element,$attrname){
		$src = $element->getAttribute($attrname);		
		$src = preg_replace("#&amp;#","&",$src);
		$src = preg_replace("# #","%20",$src);		
		$src = preg_replace("#&#","&amp;",$src);
		$element->setAttribute($attrname,$src);
	}
	
	
	private function fixImg(DomDocument $domDocument){
		$rss_url = parse_url($this->baseLink );
		
		if (empty($rss_url['scheme'])){
			return ;
		}
		$adresse = $rss_url['scheme'] ."://". $rss_url['host']."/";
		
		foreach($domDocument->getElementsByTagName('img') as $element) {
			$src = $element->getAttribute('src');
			$url_tab = parse_url($src);
			if (empty($url_tab['host'])){				
				$new_url = $adresse . $src;
				$element->setAttribute('src',$new_url);
			}	
			if ( ! $element->getAttribute('alt')){
				$element->setAttribute('alt',"pas d'alternative");
			}
			$this->fixSrc($element,'src');
		} 
	}
	
	public function fixEmptyTag(DomDocument $domDocument){
		foreach($this->emptyTagToSupress as $tag_name){
			$to_remove = array();
			foreach($domDocument->getElementsByTagName($tag_name) as $element) {
				if ($element->nodeValue == "" && $element->childNodes->length == 0){
					$to_remove[] = $element;
				}
			}
			foreach($to_remove as $element){
				$comment = $domDocument->createComment("removed emtpy $tag_name");
				$element->parentNode->replaceChild($comment,$element);
			}
		}
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
	
	public function purifyStyle(DomElement $node){
		$style = trim($node->getAttribute("style"));
		$all = explode(";",$style);
		
		$style_authorized = "";
		foreach($all as $element){
			if ( ! trim($element)){
				continue;
			}
			list($name,$value) = explode(":",$element);
			$name=trim($name);
			if (in_array($name,$this->allowStyle)){
				$style_authorized .= "$name: $value; ";
			} else {
				$this->rejectedStyle[$name] = true;
			}
		}
		$node->setAttribute("style",$style_authorized);
	}
	
	
	public function purifyAttribut(DOMElement $node){		
		$attr2remove = array();
		foreach ($node->attributes as $name => $value) {
			if (isset($this->allowAttr[$node->nodeName])){
				if (in_array($name,$this->allowAttr[$node->nodeName])){
					if ($name == "style"){
						$this->purifyStyle($node);
					}
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


 
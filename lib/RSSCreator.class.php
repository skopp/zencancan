<?php

class RSSCreator {
	
	
	private $domDocument;
	private $channel;
	
	public function __construct($title,$description,$url){	
		$this->domDocument = new DomDocument("1.0","UTF-8");
		$rss = $this->addElement($this->domDocument,"rss",false,array("version"=>'2.0'));
		$this->channel = $this->addElement($rss,"channel");
		$this->addElement($this->channel,"title",$title);
		$this->addElement($this->channel,"description",$description);
		$this->addElement($this->channel,"lastBuildDate",date("r"));
		$this->addElement($this->channel,'link',str_replace("&","&amp;",$url));
	}
		
	public function addItem($title,$link,$date,$content,$description){
		$item = $this->addElement($this->channel,"item");
		$cdata = $this->domDocument->createCDATASection($title);
		$title = $this->addElement($item,"title");
		$title->appendChild($cdata);
		$this->addElement($item,"link", $link);
		$this->addElement($item,"pubDate",date("r",strtotime($date)));
		$description_tag = $this->addElement($item,"description");
		$cdata = $this->domDocument->createCDATASection(nl2br($description));
		$description_tag->appendChild($cdata);
		
		$content_tag = $this->addElement($item,"content");
		$cdata = $this->domDocument->createCDATASection(nl2br($content));
		$content_tag->appendChild($cdata);
		
	}
	
	private function addElement(DomNode $parentNode,$elementName,$content = false,array $attributes = array()) {
		$childElement = $this->domDocument->createElement($elementName,$content);
		foreach($attributes as $name => $value){
			$childElement->setAttribute($name,$value);
		}
		$parentNode->appendChild($childElement);
		return $childElement;
	}
	
	public function getRSS(){
		return $this->domDocument->saveXML();
	}
}
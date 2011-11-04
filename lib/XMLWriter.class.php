<?php
class XMLWriter {
	
	public $domDocument;
	
	public function getRoot(){
		$this->domDocument = new DomDocument("1.0","UTF-8");
		return $this->domDocument;
	}

	private function add(DomNode $parentNode,$elementName,$content = false,array $attributes = array()) {
		$childElement = $this->domDocument->createElement($elementName,$content);
		foreach($attributes as $name => $value){
			$childElement->setAttribute($name,$value);
		}
		$parentNode->appendChild($childElement);
		return $childElement;
	}
	
	public function getXML(){
		return $this->domDocument->saveXML();
	}
	
}
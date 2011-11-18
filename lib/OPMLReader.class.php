<?php
class OPMLReader {
	
	private $lastError;
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function getInfo($ompl_content){
		$xml = simplexml_load_string($ompl_content);
		if ( ! $xml || ! $xml->body) {
			$this->lastError = "Ceci n'est pas un fichier OPML";
			return false;
		}
		
		foreach($xml->body->outline as $feed){
			$result[] = $this->outline($feed,array());
		}
		return $result;
	}
	
	public function outline($xmlElement,array $tag){

		if ($xmlElement['xmlUrl']){
			return array('xmlUrl'=>strval($xmlElement['xmlUrl']),"tag" => $tag);
		}
		$tag[] = strval($xmlElement['title']);
		$result = array();
		foreach($xmlElement->outline as $child){
			$result = array_merge($result,$this->outline($child,$tag));
		}
		return $result;
	}
	
	
}
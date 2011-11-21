<?php
class ImageFinder {
	
	public function getFirst($xml_content){
		if (! $xml_content){
			return "";
		}
		$dom = new DomDocument();
		$dom->loadHTML($xml_content);
		
		$img = $dom->getElementsByTagName('img');
		if ($img->length == 0){
			return false;
		}
		$img = $img->item(0);
		
		$src = $img->getAttribute('src');
		return $src;
	}
	
}
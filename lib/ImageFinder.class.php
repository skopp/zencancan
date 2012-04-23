<?php
class ImageFinder {

	public function getAll($xml_content){
		if (! $xml_content){
			return array();
		}
		$dom = new DomDocument();
		$dom->loadHTML($xml_content);
		$all_image = $dom->getElementsByTagName('img');
		$result = array();
		foreach($all_image as $img){
			$result[] = $img->getAttribute('src');
		}
		return $result;
	}
}
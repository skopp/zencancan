<?php


class HTMLNormalizer {
	
	public function get($html_content,$base_link){
		
		$rss_url = parse_url($base_link );
		$adresse = $rss_url['scheme'] ."://". $rss_url['host']."/";
		
		$domDocument = new DomDocument();
		$domDocument->loadHTML('<?xml encoding="UTF-8">' . $html_content);
		foreach($domDocument->getElementsByTagName('img') as $element) {
			$src = $element->getAttribute('src');
			$url_tab = parse_url($src);
			if (empty($url_tab['host'])){
				
				$new_url = $adresse . $src;
				$element->setAttribute('src',$new_url);
			}	
		}
		return $domDocument->saveHTML();
		
	}
	
	
}
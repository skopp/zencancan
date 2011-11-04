<?php
class OPMLWriter {
	
	public function send($title,array $allFeed){
		header("Content-type: text/xml; charset=UTF-8");
		header('Content-Disposition: attachment; filename="zencancan.xml"');
		echo $this->get($title,$allFeed);
	}
	
	public function get($title,array $allFeed){
		$opml = new ZenXML("opml");
		$opml['version'] = '1.0';
		$opml->head->title = $title;
		foreach($allFeed as $i => $f){
			$opml->body->outline[$i]['text'] = $f['title'];
			$opml->body->outline[$i]['title'] = $f['title'];
			$opml->body->outline[$i]['xmlURL'] = $f['url'];
			$opml->body->outline[$i]['htmlUrl'] = $f['link'];
		}
		return $opml->asXML();
	}
}



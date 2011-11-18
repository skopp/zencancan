<?php
class OPMLWriter {
	
	public function send($title,array $allFeed){
		$info = $this->get($title,$allFeed);
		header("Content-type: text/xml; charset=UTF-8");
		header('Content-Disposition: attachment; filename="zencancan.xml"');
		echo $info;
	}
	
	public function get($title,array $allFeed){
		
		foreach($allFeed as $feed){			
			$result[$feed['tag']][] = $feed;
		}
		
		$opml = new ZenXML("opml");
		$opml['version'] = '1.0';
		$opml->head->title = $title;
		$i = 0;
		foreach($result as $tag => $allf){
			if ($tag){
				$opml->body->outline[$i]['text'] = $tag;
				$opml->body->outline[$i]['title'] = $tag;
				foreach($allf as $j => $f){
					 $opml->body->outline[$i]->outline[$j]['text'] = $f['title'];
					 $opml->body->outline[$i]->outline[$j]['title'] = $f['title'];
					 $opml->body->outline[$i]->outline[$j]['xmlUrl'] = $f['url'];
					 $opml->body->outline[$i]->outline[$j]['htmlUrl'] = $f['link'];
				}
				$i++;
				
			} else {
				foreach($allf as $j => $f){
					 $opml->body->outline[$i]['text'] = $f['title'];
					 $opml->body->outline[$i]['title'] = $f['title'];
					 $opml->body->outline[$i]['xmlUrl'] = $f['url'];
					 $opml->body->outline[$i]['htmlUrl'] = $f['link'];
					 $i++;
				}
			}
					
		}
		return $opml->asXML();
	}
}



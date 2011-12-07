<?php

class FeedUpdater {
	
	const MIN_TIME_BEETWEEN_LOAD = 360;
	
	const THUMBNAIL_WIDTH = 128;
	const THUMBNAIL_HEIGHT = 80;
	
	private $feedSQL;
	private $feedItemSQL;
	private $feedFetchInfo;
	private $lastError;
	private $favicon_path;
	private $img_path;
	
	public function __construct(FeedSQL $feedSQL,FeedFetchInfo $feedFetchInfo,FeedItemSQL $feedItemSQL,$favicon_path,$img_path){
		$this->feedSQL = $feedSQL;
		$this->feedFetchInfo = $feedFetchInfo;
		$this->feedItemSQL = $feedItemSQL;
		$this->favicon_path = $favicon_path;
		$this->img_path = $img_path;
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function addWithoutFetch($url){
		if (! $url){
			return;
		}
		$info = $this->feedSQL->getInfoFromURL($url);
		if ($info){
			return $info['id_f'];
		}
		$feedInfo = array();
		$feedInfo['lasterror'] = "";
		$feedInfo['url'] = $url;
		$feedInfo['etag'] = "";
		$feedInfo['last-modified'] = date("1970-01-01");
		$feedInfo['id_item'] = "";
		$feedInfo['title'] = "En cours de récupération";
		$feedInfo['link'] = $url;
		$feedInfo['item_title'] = $url;
		$feedInfo['item_link'] =  $url;		
		$feedInfo['item_content'] = "";	
		$feedInfo['pubDate'] = date("Y-m-d H:i:s");
		$feedInfo['favicon'] = "";
		$feedInfo['item'] = array();
		$feedInfo['md5'] = 0;
		$id_f= $this->feedSQL->insert($feedInfo);
		$this->feedSQL->forceLastRecup($url);
		return $id_f;
	}
	
	public function add($url){
		
		if (! $url){
			 $this->lastError = "Aucune URL spécifiée";
			return false;
		}
		$info = $this->feedSQL->getInfoFromURL($url);
		if ($info){
			return $info['id_f'];
		}
		
		$feedInfo = $this->feedFetchInfo->getURL($url);
		
		if ( ! $feedInfo){
			$this->lastError = $this->feedFetchInfo->getLastError();
			return false;
		}
		
		$info = $this->feedSQL->getInfoFromURL($feedInfo['url']);
		if ($info){
			return $info['id_f'];
		}
		
		$feedInfo['md5'] = $this->getMD5($feedInfo);
		$feedInfo = $this->addImg($feedInfo);
		$this->feedSQL->insert($feedInfo);
		$info = $this->feedSQL->getInfoFromURL($feedInfo['url']);
		return $info['id_f'];
	}
	
	
	public function addImg($feedInfo){
		if ($feedInfo['favicon']){
			$favicon_md5 = md5(mt_rand()) .".ico";
			file_put_contents($this->favicon_path . "/" . $favicon_md5,$feedInfo['favicon']);
			$feedInfo['favicon'] = $favicon_md5;
		}
		foreach($feedInfo['item'] as $i => $item){
			$feedInfo['item'][$i]['img'] = $this->recupImg($item['img']);
		}
		return $feedInfo;
	}
	
	private function getMD5($feedInfo){
		unset($feedInfo['lastBuildDate']);
		return md5(serialize($feedInfo));
	}
	
	public function update($id_f) {
		$info = $this->feedSQL->getInfo($id_f);		
		$feedInfo = $this->feedFetchInfo->updateURL($info['url'],$info['etag'],$info['last-modified']);
		
		if (! $feedInfo){
			$this->feedSQL->udpateLastRecup($info['url'],$this->feedFetchInfo->getLastError());
			return $this->feedFetchInfo->getLastError();
		}
		
		$md5 = $this->getMD5($feedInfo);
		if ($md5 == $info['md5']){
			$this->feedSQL->udpateLastRecup($info['url'],"md5 match");
			return "md5 match";
		}
		$feedInfo['md5'] = $md5;
		$feedInfo = $this->addImg($feedInfo);
		$this->feedSQL->doUpdate($info['id_f'] , $feedInfo);
		return $feedInfo['lasterror'];
	}
	
	public function forceUpdate($id_f){
		$info = $this->feedSQL->getInfo($id_f);
		$feedInfo = $this->feedFetchInfo->updateURL($info['url'],"","");	
		if ( ! $feedInfo){
			return false;
		}
		$feedInfo['md5'] = $this->getMD5($feedInfo);
		$feedInfo = $this->addImg($feedInfo);
		return $this->feedSQL->doUpdate($id_f,$feedInfo);
	}
	
	public function updateForever(AbonnementSQL $abonnementSQL,$log_file){
		
		$info = $this->feedSQL->getFirstToUpdate();
		
		while (true) { 
			if (! $info){
				sleep(self::MIN_TIME_BEETWEEN_LOAD);
				continue;
			}
			
			$this->sleepIfNeeded($info['last_recup'],$log_file);
			
			$id_f = $info['id_f'];	
			
			if ($abonnementSQL->getNbAbonner($id_f) == 0){
				$this->feedSQL->del($id_f);
				file_put_contents($log_file,"Supression de {$info['url']}\n",FILE_APPEND);
			} else {
				file_put_contents($log_file,"Récup de {$info['url']} - ",FILE_APPEND);
				$lastError = $this->update($id_f);
				file_put_contents($log_file,"OK {$lastError}\n",FILE_APPEND);
			}
			
			$info = $this->feedSQL->getFirstToUpdate();
		}
	}
	
	private function sleepIfNeeded($lastRecup,$log_file){
		$timeToSleep =  self::MIN_TIME_BEETWEEN_LOAD - (time() - strtotime($lastRecup));
		if ( $timeToSleep > 0){
			file_put_contents($log_file,"Je m'endors pendant $timeToSleep s\n",FILE_APPEND);
			sleep( $timeToSleep);
		}
	}
	
	public function recupImg($img){
		if(! $img){
			return "";
		}
		$img_name = md5(mt_rand()).".png";
		$img_src = $this->getThumbnail($img,self::THUMBNAIL_WIDTH,self::THUMBNAIL_HEIGHT);
		if ( ! $img_src){
			return "";
		}
		imagepng($img_src,$this->img_path.$img_name);		
		return $img_name;
	}
	
	function getThumbnail($image_path,$thumbnail_width,$thumbnail_height) {
		
		@ $img_content = file_get_contents($image_path);
		if (! $img_content){
			return false;
		}
	    @ $myImage = imagecreatefromstring($img_content);
	    if (! $myImage){
	    	return false;
	    }
	    
		$width_orig = imagesx($myImage);
		$height_orig = imagesy($myImage);
	    $ratio_orig = $width_orig/$height_orig; 
	    
	    
	    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
	       $new_height = $thumbnail_width/$ratio_orig;
	       $new_width = $thumbnail_width;
	    } else {
	       $new_width = $thumbnail_height*$ratio_orig;
	       $new_height = $thumbnail_height;
	    }
	   
	    $x_mid = $new_width/2;  //horizontal middle
	    $y_mid = $new_height/2; //vertical middle
	   
	    $process = imagecreatetruecolor(round($new_width), round($new_height));
	   
	    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
	
	    imagedestroy($process);
	    imagedestroy($myImage);
	    return $thumb;
	}
	
	
}
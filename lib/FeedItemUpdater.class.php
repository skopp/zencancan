<?php 

class FeedItemUpdater {
	
	const THUMBNAIL_WIDTH = 128;
	const THUMBNAIL_HEIGHT = 80;
	
	private $feedItemSQL;
	private $img_path;
	private $feedSQL;
	
	
	public function __construct(FeedItemSQL $feedItemSQL,FeedSQL $feedSQL,$img_path){
		$this->feedItemSQL = $feedItemSQL;
		$this->img_path = $img_path;
		$this->feedSQL = $feedSQL;
	}
	
	private function isModified($sql_item,$rss_item){
		$rss_item['id'] = $rss_item['id_item'];
		$rss_item['date'] = $rss_item['pubDate'];
		
		foreach(array('title','link','description','content','date','id') as $key){
			if ($sql_item[$key] != $rss_item[$key]){
				return true;
			}
		}
		return false;
	}
	
	private function addItem($id_f,$rssInfo){
		$rssInfo['img'] = $this->recupImg($rssInfo['all_img']);
		$this->feedItemSQL->add($id_f,$rssInfo);	
	}
	
	private function deleteItem($id_i,$img){
		@ unlink($this->img_path . "/" . $item['img']);
		$this->feedItemSQL->delete($id_i);
	}
	
	public function update($id_f,array $feedInfo){
		$rssInfo = array();		
		foreach($feedInfo['item'] as $item){
			$rssInfo[$item['id_item']] = $item;
		}
		$sqlInfo = array();
		foreach($this->feedItemSQL->getAll($id_f) as $item){
			$sqlInfo[$item['id']] = $item;			
		}
		foreach($sqlInfo as $id => $item){
			if (empty($rssInfo[$id])){
				$this->deleteItem($item['id_i'],$item['img']);
				continue;
			}
			if ($this->isModified($item,$rssInfo[$id])){
				$this->deleteItem($item['id_i'],$item['img']);
				$this->addItem($id_f,$rssInfo[$id]);	
			}
			unset($rssInfo[$id]);
		}
		foreach($rssInfo as $id => $item){
			$this->addItem($id_f,$rssInfo[$id]);	
		}
		$last_id = $this->feedItemSQL->getLastId($id_f);
		$this->feedSQL->updateLastId($id_f,$last_id);
	}
	
	public function recupImg(array $all_img){
		$img_name = md5(mt_rand()).".png";
		foreach($all_img as $img){
			$img_src = $this->getThumbnail($img,self::THUMBNAIL_WIDTH,self::THUMBNAIL_HEIGHT);
			if ( $img_src){
				imagepng($img_src,$this->img_path.$img_name);
				return $img_name;
			}
		}
		
		return false;
	}
	
	private function getThumbnail($image_path,$thumbnail_width,$thumbnail_height) {
		
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
		
		if ($width_orig<$thumbnail_width || $height_orig< $thumbnail_height){
			return false;
		}
		
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
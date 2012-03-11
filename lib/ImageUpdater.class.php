<?php 
class ImageUpdater {
	
	const THUMBNAIL_WIDTH = 128;
	const THUMBNAIL_HEIGHT = 80;
	
	const MIN_TIME_BEETWEEN_LOAD = 60;
	
	private $feedItemSQL;
	private $img_path;
	private $favicon_path;
	private $imageFinder;
	private $feedSQL;
	
	public function __construct(FeedSQL $feedSQL,FeedItemSQL $feedItemSQL,ImageFinder $imageFinder,$img_path,$favicon_path){
		$this->feedItemSQL = $feedItemSQL;
		$this->imageFinder = $imageFinder;
		$this->img_path = $img_path;
		$this->feedSQL = $feedSQL;
		$this->favicon_path = $favicon_path;
	}
	
	public function updateAll(){
		$start = time();
		$this->updateThumbnail();
		$this->updateFavicon();
		$stop = time();
		$sleep = self::MIN_TIME_BEETWEEN_LOAD - ($stop -$start);
		if ($sleep > 0){
			echo "Arret du script : $sleep";
			sleep($sleep);
		}
	}

	private function updateThumbnail(){
		$all_item = $this->feedItemSQL->getAllImageUpdate();
		echo "Nombre d'image à mettre à jour : ". count($all_item) ."\n";
		foreach($all_item as $item){
			$info = $this->feedItemSQL->getInfo($item['id_i']);
			$all_image = $this->imageFinder->getAll($info['content']);
			$img = $this->recupImg($all_image);
			$this->feedItemSQL->updateImage($item['id_i'],$img);
		}
	}
	
	private function updateFavicon(){
		$all_favicon = $this->feedSQL->getAllFaviconToUpdate();
		echo "Nombre de favicon à mettre à jour : " . count($all_favicon) . "\n";
		foreach($all_favicon as $item){
			$info = $this->feedSQL->getInfo($item['id_f']);
			$favicon = $this->getFavicon($info);
			$this->feedSQL->updateFavicon($item['id_f'],$favicon);
		}
	}
	
	
	private function recupImg(array $all_img){
		$img_name = md5(mt_rand()).".png";
		foreach($all_img as $img){
			echo "Recupération de $img \n";
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
	
	private function getFavicon($feedInfo){
		
		if ($feedInfo['favicon']){
			$this->removeImage($feedInfo['id_f']);
		}
		
		$faviconContent = $this->getFaviconContent($feedInfo['url']);
		if (! $faviconContent ){
			return false;
		}
		
		$favicon_name = md5(mt_rand()) .".ico";
		file_put_contents($this->favicon_path . "/$favicon_name",$faviconContent);
		return $favicon_name;
	}
	
	private function getFaviconContent($url){
		echo "Récupération de : $url\n";
		$parse = parse_url($url);
		$favicon = $parse['scheme'] . "://".$parse['host']."/favicon.ico";
		@ $content = file_get_contents($favicon);
		return $content;
	}
	
	private function removeImage($id_f){
		$info = $this->feedSQL->getInfo($id_f);
		if ($info['favicon']) {
			@ unlink($this->favicon_path . "/" . $info['favicon']);
		}
	}
	
	public function removeAllImage($id_f){
		$this->removeImage($id_f);
		foreach($this->feedItemSQL->getAllImage($id_f) as $image){
				@ unlink($this->img_path . "/" . $image);
		}	
	}
}
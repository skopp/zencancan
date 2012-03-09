<?php 
class FeedItemUpdater {

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
				@ unlink($this->img_path . "/" . $item['img']);
				$this->feedItemSQL->delete($item['id_i']);
				continue;
			}
			if ($this->isModified($item,$rssInfo[$id])){
				$this->feedItemSQL->update($item['id_i'],$rssInfo[$id]);	
			}
			unset($rssInfo[$id]);
		}
		foreach($rssInfo as $id => $item){
			$this->feedItemSQL->add($id_f,$rssInfo[$id]);	
				
		}
		$last_id = $this->feedItemSQL->getLastId($id_f);
		$this->feedSQL->updateLastId($id_f,$last_id);
	}
}
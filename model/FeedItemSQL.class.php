<?php 

class FeedItemSQL extends SQL {
	
	public function getAll($id_f){
		$sql = "SELECT * FROM feed_item WHERE id_f=? ORDER BY date DESC";
		return $this->query($sql,$id_f);
	}

	public function getInfo($id_i){
		$sql = "SELECT * FROM feed_item WHERE id_i=?";
		return $this->queryOne($sql,$id_i);
	}
	
	public function add($id_f,array $itemInfo){
		$sql = "INSERT INTO feed_item(id_f,id,title, link, description, content,date,img) VALUES (?,?,?,?,?,?,?,?)";
		$this->query($sql,$id_f,$itemInfo['id_item'],$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$itemInfo['content'],$itemInfo['pubDate'],$itemInfo['img']);		
	}
	
	public function getLastId($id_f){
		$sql = "SELECT id_i FROM feed_item WHERE id_f=? ORDER BY date DESC LIMIT 1";
		return $this->queryOne($sql,$id_f);
	}
	
	
	public function doUpdate($id_f,array $feedInfo){
		$sql = "DELETE FROM feed_item WHERE id_f=?";
		$this->query($sql,$id_f);
		foreach($feedInfo['item'] as $itemInfo){
			$this->updateItem($id_f,$itemInfo);
		}
		$sql = "SELECT id_i FROM feed_item WHERE id_f=? ORDER BY date DESC LIMIT 1";
		$last_id_i = $this->queryOne($sql,$id_f);
		$sql = "UPDATE feed SET last_id_i = ? WHERE id_f=?";
		$this->query($sql,$last_id_i,$id_f);
		
	}
	
	private function updateItem($id_f,array $itemInfo){
		$info = $this->getInfoFromRSSId($id_f,$itemInfo['id_item']);
		if ($info){
			$this->updateIfNeeded($id_f,$itemInfo,$info);
			return ;
		}
		$sql = "INSERT INTO feed_item(id_f,id,title, link, description, content,date,img) VALUES (?,?,?,?,?,?,?,?)";
		$this->query($sql,$id_f,$itemInfo['id_item'],$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$itemInfo['content'],$itemInfo['pubDate'],$itemInfo['img']);
	}
	
	public function updateIfNeeded($id_f,$itemInfo){
		$sql = "UPDATE feed_item SET title=?,link=?,description=?,content=?,date=?,img=? WHERE id_f=? AND id=?";
		$this->query($sql,$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$itemInfo['content'],$itemInfo['pubDate'],$itemInfo['img'],$id_f,$itemInfo['id_item']);
	}
		
	private function getInfoFromRSSId($id_f,$id){
		$sql = "SELECT * FROM feed_item WHERE id_f = ? AND id=? ";
		return $this->queryOne($sql,$id_f,$id);
	}
	
	public function delete($id_i){
		$sql = "DELETE FROM feed_item WHERE id_i=?";
		$this->query($sql,$id_i);
	}
	
}
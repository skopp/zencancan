<?php 

class FeedItemSQL extends SQL {
	
	public function getAll($id_f){
		$sql = "SELECT * FROM feed_item WHERE id_f=? ORDER BY date DESC,id_i ASC";
		return $this->query($sql,$id_f);
	}

	public function getInfo($id_i){
		$sql = "SELECT * FROM feed_item WHERE id_i=?";
		return $this->queryOne($sql,$id_i);
	}
	
	public function add($id_f,array $itemInfo){
		$sql = "INSERT INTO feed_item(id_f,id,title, link, description, content,date,image_update) VALUES (?,?,?,?,?,?,?,?)";
		$this->query($sql,$id_f,$itemInfo['id_item'],$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$itemInfo['content'],$itemInfo['pubDate'],true);		
	}
	
	public function update($id_f,$itemInfo){
		$sql = "UPDATE feed_item SET title=?,link=?,description=?,content=?,date=?,image_update=? WHERE id_f=?";
		$this->query($sql,$itemInfo['title'],$itemInfo['link'],$itemInfo['description'],$itemInfo['content'],$itemInfo['pubDate'],true,$id_f);
	}
	
	public function getLastId($id_f){
		$sql = "SELECT id_i FROM feed_item WHERE id_f=? ORDER BY date DESC,id_i ASC LIMIT 1";
		return $this->queryOne($sql,$id_f);
	}
	
	public function delete($id_i){
		$sql = "DELETE FROM feed_item WHERE id_i=?";
		$this->query($sql,$id_i);
	}
	
	public function getAllImageUpdate(){
		$sql = "SELECT id_i FROM feed_item WHERE image_update=?";
		return $this->query($sql,true);
	}
	
	public function updateImage($id_i,$img){
		$sql = "UPDATE feed_item SET img=?,image_update=? WHERE id_i=?";
		return $this->query($sql,$img,false,$id_i);
	}
	
	public function deleteAll($id_f){
		$sql = "DELETE FROM feed_item WHERE id_f=?";
		$this->query($sql,$id_f);
	}
	
	public function getAllImage($id_f){
		$sql = "SELECT img FROM feed_item WHERE id_f=?";
		$result = array();
		foreach($this->query($sql,$id_f) as $line){
			$result[] = $line['img'];
		}
		return $result;
	}
}
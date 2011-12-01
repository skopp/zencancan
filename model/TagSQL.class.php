<?php 

class TagSQL extends SQL {

	public function add($id_u,$id_f,$tag){
		$sql = "SELECT count(*) FROM tag WHERE id_u=? AND id_f=? AND tag = ?";
		if ($this->queryOne($sql,$id_u,$id_f,$tag)){
			return;
		}
		$sql = "INSERT INTO tag(id_u,id_f,tag) VALUES (?,?,?);";
		$this->query($sql,$id_u,$id_f,$tag);
	}
	
	public function remove($id_u,$id_f,$tag){
		$sql = "DELETE FROM tag WHERE id_u = ? AND id_f = ? AND tag=?";
		$this->query($sql,$id_u,$id_f,$tag);
	}
	
	public function getAllTag($id_u){
		$sql = "SELECT distinct tag FROM tag WHERE id_u=? ORDER BY tag";
		$result = array();
		foreach($this->query($sql,$id_u) as $row){
			$result[] = $row['tag'];
		}
		return $result;
	}
	
	public function getAll($id_u,$id_f){
		$sql = "SELECT tag FROM tag WHERE id_u=? AND id_f=?";
		$result = array();
		foreach($this->query($sql,$id_u,$id_f) as $row){
			$result[] = $row['tag'];
		}
		return $result;
	}
	
	public function delAll($id_u,$id_f){
		$sql = "DELETE FROM tag WHERE id_u = ? AND id_f = ? ";
		$this->query($sql,$id_u,$id_f);		
	}
	
}
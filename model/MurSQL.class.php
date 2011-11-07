<?php


class MurSQL extends SQL {
	
	public function add($id_u,$content,$title = "",$link=""){
		$this->query("INSERT INTO mur(id_u,content,date,title,link) VALUES (?,?,now(),?,?)",$id_u,$content,$title,$link);
	}
	
	public function getLastItem($id_u,$offset){
		$offset = intval($offset);
		if ($offset <0 ){
			$offset = 0;
		}
		$limit = 20;
		$sql = "SELECT * FROM mur WHERE id_u=? ORDER BY date DESC LIMIT $offset,$limit";
		return $this->query($sql,$id_u);
	}

	public function delete($id_u,$id_m){
		$this->query("DELETE FROM mur WHERE id_u=? AND id_m=?",$id_u,$id_m);
	}
	
}
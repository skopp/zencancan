<?php


class MurSQL extends SQL {
	
	public function add($id_u,$content){
		$this->query("INSERT INTO mur(id_u,content,date) VALUES (?,?,now())",$id_u,$content);
	}
	
}
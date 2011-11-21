<?php


class MurSQL extends SQL {
	
	public function add($id_u,$content,$title = "",$link="",$description="",$img=""){
		if (! $description){
			$description = $content;
		}
		$this->query("INSERT INTO mur(id_u,content,date,title,link,description,img) ". 
					" VALUES (?,?,now(),?,?,?,?)",$id_u,$content,$title,$link,$description,$img);
		$this->updateUtilisateur($id_u);		
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
		$this->updateUtilisateur($id_u);	
	}
	
	public function updateUtilisateur($id_u){
		$sql = "SELECT count(*) from mur where id_u=?";
		$nb = $this->queryOne($sql,$id_u);
		$sql = "UPDATE compte SET nb_publication=?, last_publication=now() WHERE id_u=?";
		$this->query($sql,$nb,$id_u);
	}
	
}
<?php

class AbonnementSQL extends SQL {
	
	const NB_DISPLAY = 30;
	
	public function getNbAbo(){
		return $this->queryOne("SELECT count(distinct id_u) FROM abonnement ");
	}
	
	public function isAbonner($id_u,$id_f){
		$sql = "SELECT count(*) FROM abonnement WHERE id_u=? AND id_f = ? ";
		return $this->queryOne($sql,$id_u,$id_f);
	}
	
	public function add($id_u,$id_f,$tag){
		$sql = "DELETE FROM abonnement WHERE id_u=? AND id_f=?";
		$this->query($sql,$id_u,$id_f);
		$sql = "INSERT INTO abonnement(id_u,id_f,tag) VALUES (?,?,?)";
		$this->query($sql,$id_u,$id_f,$tag);
		$this->updateUtilisateurAbonnement($id_u);
	}
	
	public function del($id_u,$id_f){
		$sql = "DELETE FROM abonnement WHERE id_u=? AND id_f=?";
		$this->query($sql,$id_u,$id_f);
		$this->updateUtilisateurAbonnement($id_u);
	}
	
	public function updateUtilisateurAbonnement($id_u){
		$sql = "UPDATE compte set nb_abonnement = " .
				" (SELECT count(id_f) FROM abonnement " .
				" WHERE abonnement.id_u=?) WHERE id_u=?;";
		$this->query($sql,$id_u,$id_u);
	}
	
	public function getAll($id_u){
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id_u=?" . 
				" ORDER BY last_maj DESC";
		return $this->query($sql,$id_u);
	}
	
	public function getWithContentWithTag($id_u,$offset,$tag){
			$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id_u=? AND abonnement.tag=?" . 
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->query($sql,$id_u,$tag);	
	}
	
	public function getWithContent($id_u,$offset,$tag){
		if ($tag){
			return $this->getWithContentWithTag($id_u,$offset,$tag);
		}
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id_u=?" . 
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->query($sql,$id_u);	
	}
	
	public function getByTag($id_u,$tag,$offset){
		$sql = "SELECT last_id,abonnement.id_f,last_maj,last_recup,title,item_link,item_title,item_content FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id_u=? AND abonnement.tag=?" .
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->query($sql,$id_u,$tag);
	}
	
	public function get($id_u,$tag,$offset){
		if ($tag){
			return $this->getByTag($id_u,$tag,$offset);
		}
		$sql = "(SELECT last_id,a.id_f,tag,last_maj,last_recup,title,item_link,item_title, item_content" .
  					" FROM abonnement as a JOIN feed On a.id_f=feed.id_f " .
 					" WHERE last_maj = " . 
 					" ( SELECT MAX(last_maj) "." FROM abonnement " . 
 					" JOIN feed ON abonnement.id_f=feed.id_f" . 
 					" WHERE tag = a.tag and id_u=? ) AND id_u=?  and tag!='' ". 
				" ) ".
				" UNION " . 
					"(SELECT last_id,abonnement.id_f,tag,last_maj,last_recup,title,item_link,item_title,item_content" .
  					" FROM abonnement  JOIN feed On abonnement.id_f=feed.id_f " . 
					" WHERE tag='' AND id_u=? ) " .
				" ORDER BY last_maj DESC " . 
				" LIMIT $offset,".self::NB_DISPLAY;
		return $this->query($sql,$id_u,$id_u,$id_u);
	}
	
	public function getNbAbonner($id_f){
		$sql = "SELECT count( * ) FROM `abonnement` WHERE id_f =?";
		return $this->queryOne($sql,$id_f);
	}
	
	public function getNbFlux($id_u,$tag = ''){
		$sql = "SELECT count( * ) FROM abonnement WHERE id_u =? ";
		$info[] = $id_u;
		if ($tag) {
			$sql .= " AND tag=?";
			$info[] = $tag;
		}
		return $this->queryOne($sql,$info);
	}
	
	public function addTag($id_u,$id_f,$tag){
		$sql = "UPDATE abonnement SET tag=? WHERE id_u=? AND id_f=?";
		$this->query($sql,$tag,$id_u,$id_f);
	}
	
	public function getInfo($id_u,$id_f){
		$sql = "SELECT * FROM abonnement JOIN feed ON abonnement.id_f=feed.id_f WHERE id_u=? AND abonnement.id_f = ? ";
		return $this->queryOne($sql,$id_u,$id_f);
	}
	
	public function delCompte($id_u){
		$sql = "DELETE FROM abonnement WHERE id_u=?";
		$this->query($sql,$id_u);
	}
	
}
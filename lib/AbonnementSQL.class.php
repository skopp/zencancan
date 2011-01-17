<?php

class AbonnementSQL {
	
	const NB_DISPLAY = 30;
	
	private $sqlQuery;
	
	public function __construct($sqlQuery){
		$this->sqlQuery = $sqlQuery;	
	}
	
	public function isAbonner($id,$id_f){
		$sql = "SELECT count(*) FROM abonnement WHERE id=? AND id_f = ? ";
		return $this->sqlQuery->queryOne($sql,$id,$id_f);
	}
	
	public function add($id,$id_f){
		if ($this->isAbonner($id,$id_f)){
			return;
		}
		$sql = "INSERT INTO abonnement(id,id_f) VALUES (?,?)";
		$this->sqlQuery->query($sql,$id,$id_f);
	}
	
	function del($id,$id_f){
		$sql = "DELETE FROM abonnement WHERE id=? AND id_f=?";
		$this->sqlQuery->query($sql,$id,$id_f);
	}
	
	public function getAll($id){
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id=?" . 
				" ORDER BY last_maj DESC";
		return $this->sqlQuery->query($sql,$id);
	}
	
	public function getWithContent($id,$offset){
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id=?" . 
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->sqlQuery->query($sql,$id);	
	}
	
	public function getByTag($id,$tag,$offset){
		$sql = "SELECT abonnement.id_f,last_maj,last_recup,title,item_link,item_title FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id=? AND abonnement.tag=?" .
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->sqlQuery->query($sql,$id,$tag);
	}
	
	public function get($id,$tag,$offset){
		if ($tag){
			return $this->getByTag($id,$tag,$offset);
		}
		$sql = "(SELECT a.id_f,tag,last_maj,last_recup,title,item_link,item_title
  FROM abonnement as a JOIN feed On a.id_f=feed.id_f
 WHERE last_maj =
       ( SELECT MAX(last_maj)
           FROM abonnement JOIN feed On abonnement.id_f=feed.id_f
          WHERE tag = a.tag and id=? ) AND id=?  and tag!='' 
)
UNION 
(SELECT abonnement.id_f,tag,last_maj,last_recup,title,item_link,item_title
  FROM abonnement  JOIN feed On abonnement.id_f=feed.id_f
WHERE tag='' AND id=? )

ORDER BY last_maj DESC LIMIT $offset,".self::NB_DISPLAY;
		/*$sql = "SELECT abonnement.id_f,tag,last_maj,last_recup,title,item_link,item_title FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id=?" .
				" GROUP BY tag ".
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;*/
		
		return $this->sqlQuery->query($sql,$id,$id,$id);
	}
	
	public function getNbAbonner($id_f){
		$sql = "SELECT count( * ) FROM `abonnement` WHERE id_f =?";
		return $this->sqlQuery->queryOne($sql,$id_f);
	}
	
	public function getNbFlux($id){
		$sql = "SELECT count( * ) FROM abonnement WHERE id =?";
		return $this->sqlQuery->queryOne($sql,$id);
	}
	
	public function addTag($id,$id_f,$tag){
		$sql = "UPDATE abonnement SET tag=? WHERE id=? AND id_f=?";
		$this->sqlQuery->query($sql,$tag,$id,$id_f);
	}
	
	public function getInfo($id,$id_f){
		$sql = "SELECT * FROM abonnement WHERE id=? AND id_f = ? ";
		return $this->sqlQuery->queryOne($sql,$id,$id_f);
	}
	
}
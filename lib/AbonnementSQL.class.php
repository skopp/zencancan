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
	
	public function getAll($id,$offset){
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id=?" . 
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		return $this->sqlQuery->query($sql,$id);
	}
	
	public function getNbAbonner($id_f){
		$sql = "SELECT count( * ) FROM `abonnement` WHERE id_f =?";
		return $this->sqlQuery->queryOne($sql,$id_f);
	}
	
	public function getNbFlux($id){
		$sql = "SELECT count( * ) FROM abonnement WHERE id =?";
		return $this->sqlQuery->queryOne($sql,$id);
	}
	
}
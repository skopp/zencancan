<?php

class AbonnementSQL {
	
	private $sqlQuery;
	
	public function __construct($sqlQuery){
		$this->sqlQuery = $sqlQuery;	
	}
	
	public function isAbonner($id,$url){
		$sql = "SELECT count(*) FROM abonnement WHERE id=? AND url = ? ";
		return $this->sqlQuery->queryOne($sql,$id,$url);
	}
	
	public function add($id,$url){
		if ($this->isAbonner($id,$url)){
			return;
		}
		$sql = "INSERT INTO abonnement(id,url) VALUES (?,?)";
		$this->sqlQuery->query($sql,$id,$url);
	}
	
	public function getAll($id){
		$sql = "SELECT * FROM abonnement " . 
				" JOIN feed ON abonnement.url = feed.url " . 
				" WHERE id=?" . 
				" ORDER BY last_maj DESC";
		
		return $this->sqlQuery->query($sql,$id);
	}
	
}
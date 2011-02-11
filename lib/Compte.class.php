<?php
class Compte {
	
	private $sqlQuery;
	private $lastError;
	
	public function __construct($sqlQuery){
		$this->sqlQuery = $sqlQuery;
	}
	
	public function create($id,$name,$password){
		if ($this->exists($name)){
			$this->lastError = "Ce nom est déjà utilisé";
			return false;
		}
		
		$sql = "INSERT INTO compte(id,name,password,date) VALUES (?,?,?,now())";
		$this->sqlQuery->query($sql,$id,$name,crypt($password));
		return true;
	}
	
	public function verif($username,$password){
		$sql = "SELECT * FROM compte WHERE name = ?";
		$info = $this->sqlQuery->queryOne($sql,$username);
		
		if ( ! $info){
			return false;
		}	
		
		if ( crypt($password, $info['password']) != $info['password'] ){
			return false;
		}
		return $info['id'];
	}
	
	public function exists($name){
		$sql = "SELECT count(*) FROM compte WHERE name = ?";
		return $this->sqlQuery->queryOne($sql,$name);
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function getAccountName($id){
		$sql = "SELECT name FROM compte WHERE id = ?";
		return $this->sqlQuery->queryOne($sql,$id);
	}
	
	public function isAdmin($id){
		$sql = "SELECT is_admin FROM compte WHERE id=?";
		return  $this->sqlQuery->queryOne($sql,$id);
	}
	
	public function delete($name){
		$sql = "DELETE FROM compte WHERE name=?";
		$this->sqlQuery->query($sql,$name);
	}
	
	public function getRemember($id){
		$remember = $this->sqlQuery->queryOne("SELECT remember FROM compte WHERE id= ?",$id);
		if ($remember){
			return $remember;
		}
		$remember = md5(mt_rand(0,mt_getrandmax()));
		$this->sqlQuery->query("UPDATE compte SET remember=? WHERE id=?",$remember,$id);
		return $remember;
	}
	
	public function verifRemember($name,$remember){
		$sql = "SELECT id FROM compte WHERE name=? AND remember=?";
		return $this->sqlQuery->queryOne($sql,$name,$remember);
	}
	
	public function verifWithoutName($remember){
		$sql = "SELECT name FROM compte WHERE remember=?";
		return $this->sqlQuery->queryOne($sql,$remember);
	}

	public function deleteRemember($id){
		$sql = "UPDATE compte set remember='' WHERE id=?";
		$this->sqlQuery->query($sql,$id);
	}
	
	public function setPassword($id,$password){
			$sql = "UPDATE compte set password=? WHERE id=?";
		$this->sqlQuery->query($sql,crypt($password),$id);
	}
	
	public function getNbAccount(){
		return $this->sqlQuery->queryOne("SELECT count(*) FROM compte");
			
	}
	
}
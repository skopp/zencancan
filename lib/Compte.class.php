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
		
		$sql = "INSERT INTO compte(id,name,password) VALUES (?,?,?)";
		$this->sqlQuery->query($sql,$id,$name,crypt($password));
		return true;
	}
	
	public function verif($username,$password){
		$sql = "SELECT * FROM compte WHERE name = ?";
		$info = $this->sqlQuery->queryOne($sql,$username);
		
		if ( ! $info){
			return false;
		}	
		if ( ! crypt($password, $info['password']) == $info['password'] ){
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
	
	public function delete($name){
		$sql = "DELETE FROM compte WHERE name=?";
		$this->sqlQuery->query($sql,$name);
	}
	
	
}
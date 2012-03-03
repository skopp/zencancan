<?php
class UtilisateurSQL extends SQL {
	
	private $lastError;
		
	public function create($id,$name,$password){
		if ($this->exists($name)){
			$this->lastError = "Ce nom est déjà utilisé";
			return false;
		}
		
		$sql = "INSERT INTO compte(id,name,password,date) VALUES (?,?,?,now())";
		$this->query($sql,$id,$name,crypt($password));
		return true;
	}
	
	public function verif($username,$password){
		$sql = "SELECT id_u,password FROM compte WHERE name = ?";
		$info = $this->queryOne($sql,$username);
		
		if ( ! $info){
			return false;
		}	
		
		if ( crypt($password, $info['password']) != $info['password'] ){
			return false;
		}
		return $info['id_u'];
	}
	
	public function exists($name){
		$sql = "SELECT count(*) FROM compte WHERE name = ?";
		return $this->queryOne($sql,$name);
	}
	
	public function getIdFromUsername($name){
		$sql = "SELECT id_u FROM compte WHERE name = ?";
		return $this->queryOne($sql,$name);
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function isAdmin($id_u){
		$sql = "SELECT is_admin FROM compte WHERE id_u=?";
		return  $this->queryOne($sql,$id_u);
	}
	
	public function delete($name){
		$sql = "DELETE FROM compte WHERE name=?";
		$this->query($sql,$name);
	}
	
	public function getRemember($id_u){
		$remember = $this->queryOne("SELECT remember FROM compte WHERE id_u= ?",$id_u);
		if ($remember){
			return $remember;
		}
		$remember = md5(mt_rand(0,mt_getrandmax()));
		$this->query("UPDATE compte SET remember=? WHERE id_u=?",$remember,$id_u);
		return $remember;
	}
	
	public function getInfoFromRemember($remember){
		$sql = "SELECT * FROM compte WHERE remember=?";
		return $this->queryOne($sql,$remember);
	}
	
	public function verifWithoutName($remember){
		$sql = "SELECT name FROM compte WHERE remember=?";
		return $this->queryOne($sql,$remember);
	}

	public function deleteRemember($id_u){
		$sql = "UPDATE compte set remember='' WHERE id_u=?";
		$this->query($sql,$id);
	}
	
	public function setPassword($id_u,$password){
			$sql = "UPDATE compte set password=? WHERE id_u=?";
		$this->query($sql,crypt($password),$id_u);
	}
	
	public function getNbAccount(){
		return $this->queryOne("SELECT count(*) FROM compte");
	}
	
	public function getInfo($id_u){
		return $this->queryOne("SELECT * FROM compte WHERE id_u = ?",$id_u);	
	}
	
	public function getAll($tri = "last_login",$offset = 0){
		if (! in_array($tri,array("last_login",
									"name",
									"date",
									"nb_abonnement",
									"nb_publication",
									"last_publication",
									))){
			$tri = "last_login";
		}
		if ($tri == "name"){
			$tri = $tri . " ASC";
		} else {
			$tri = $tri . " DESC";
		}
		return  $this->query("SELECT * FROM compte ORDER BY $tri");		
	}
	
	public function updateLastLogin($id_u){
		$sql = "UPDATE compte SET last_login = now() WHERE id_u=?";
		$this->query($sql,$id_u);
	}	
	
}
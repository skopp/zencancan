<?php

class AbonnementSQL extends SQL {
	
	const NB_DISPLAY = 30;
	const TAG_SEPARATOR = ";";
	
	private $tagSQL;
	
	public function __construct(SQLQuery $sqlQuery,TagSQL $tagSQL){
		parent::__construct($sqlQuery);
		$this->tagSQL = $tagSQL;
	}
	
	public function getNbAbo(){
		return $this->queryOne("SELECT count(distinct id_u) FROM abonnement ");
	}
	
	public function isAbonner($id_u,$id_f){
		$sql = "SELECT count(*) FROM abonnement WHERE id_u=? AND id_f = ? ";
		return $this->queryOne($sql,$id_u,$id_f);
	}
	
	public function add($id_u,$id_f){
		$sql = "DELETE FROM abonnement WHERE id_u=? AND id_f=?";
		$this->query($sql,$id_u,$id_f);
		$sql = "INSERT INTO abonnement(id_u,id_f) VALUES (?,?)";
		$this->query($sql,$id_u,$id_f);
		$this->updateUtilisateurAbonnement($id_u);
	}
	
	public function del($id_u,$id_f){
		$sql = "DELETE FROM abonnement WHERE id_u=? AND id_f=?";
		$this->query($sql,$id_u,$id_f);
		$this->updateUtilisateurAbonnement($id_u);
		$this->tagSQL->delAll($id_u,$id_f);
	}
	
	public function updateUtilisateurAbonnement($id_u){
		$sql = "UPDATE compte set nb_abonnement = " .
				" (SELECT count(id_f) FROM abonnement " .
				" WHERE abonnement.id_u=?) WHERE id_u=?;";
		$this->query($sql,$id_u,$id_u);
	}
	
	public function getAll($id_u){
		$sql = "SELECT '' as tag,title,url,link FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE abonnement.id_u=? AND tag=''" . 
				" ORDER BY last_maj DESC";
		$result = $this->query($sql,$id_u);
		
		$sql = "SELECT tag.tag,title,url,link FROM tag " .
				" JOIN abonnement ON tag.id_u=abonnement.id_u AND tag.id_f=abonnement.id_f" . 
					" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE abonnement.id_u=? AND abonnement.tag != ''";
		$result = array_merge($result,$this->query($sql,$id_u));
		return $result;
		
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
		$sql = "SELECT abonnement.tag,last_id,tag.id_f,last_maj,last_recup,title,item_link,item_title,item_content " .
				" FROM tag " . 
				" JOIN feed ON tag.id_f = feed.id_f " .
				" JOIN abonnement ON tag.id_f = abonnement.id_f AND tag.id_u=abonnement.id_u ".
				" WHERE tag.id_u=? AND tag.tag=?" .
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		$result = $this->query($sql,$id_u,$tag);
		foreach($result as $i => $line){
			$result[$i]['tag'] =  $this->tagList2Array($line['tag']);
		}
		return $result;
	}
	
	public function get($id_u,$tag,$offset){
		if ($tag){
			return $this->getByTag($id_u,$tag,$offset);
		}
		$sql = "SELECT last_id,abonnement.id_f,last_maj,last_recup,title,item_link,item_title,item_content,tag " . 
				" FROM abonnement " . 
				" JOIN feed ON abonnement.id_f = feed.id_f " . 
				" WHERE id_u=? ".
				" ORDER BY last_maj DESC".
				" LIMIT $offset,".self::NB_DISPLAY;
		
		$result = $this->query($sql,$id_u);
		foreach($result as $i => $line){
			$result[$i]['tag'] = $this->tagList2Array($line['tag']);
		}
		return $result;
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
		$this->tagSQL->add($id_u,$id_f,$tag);
		$this->updateTag($id_u,$id_f);			
	}
	
	public function delTag($id_u,$id_f,$tag){
		$this->tagSQL->remove($id_u,$id_f,$tag);
		$this->updateTag($id_u,$id_f);	
	}
	
	public function updateTag($id_u,$id_f){
		$all_tag = $this->tagSQL->getAll($id_u,$id_f);
		$all_tag = implode(self::TAG_SEPARATOR,$all_tag);
		$sql = "UPDATE abonnement SET tag=? WHERE id_u=? AND id_f=?";
		$this->query($sql,$all_tag,$id_u,$id_f);
	}
	
	public function getInfo($id_u,$id_f){
		$sql = "SELECT * FROM abonnement JOIN feed ON abonnement.id_f=feed.id_f WHERE id_u=? AND abonnement.id_f = ? ";
		$result = $this->queryOne($sql,$id_u,$id_f);
		$result['tag'] = $this->tagList2Array($result['tag']);
		return $result;
	}
	
	public function delCompte($id_u){
		$sql = "DELETE FROM abonnement WHERE id_u=?";
		$this->query($sql,$id_u);
	}
	
	public function taglist2Array($tag_list){
		$r = explode(self::TAG_SEPARATOR,trim($tag_list));
		if (! $r[0]){
			return array();
		}
		return $r;
	}
	
}
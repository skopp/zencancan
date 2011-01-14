<?php

class FeedSQL {
	
	private $sqlQuery;
		
	public function __construct(SQLQuery $sqlQuery){
		$this->sqlQuery = $sqlQuery;
	}
	
	public function getInfo($url){
		$sql = "SELECT * FROM feed WHERE url = ?";
		return $this->sqlQuery->queryOne($sql,$url);
	}
	
	public function add(array $feedInfo){
		$infoFromDB = $this->getInfo($feedInfo['url']);
		if ($infoFromDB){
			$this->doUpdate($infoFromDB['last_id'] , $feedInfo);
		} else {
			$this->insert($feedInfo);
		}
	}
	
	public function doUpdate($lastId, $feedInfo){
		if ($lastId == $feedInfo['id_item']) {
			$this->udpateLastRecup($feedInfo['url']);
		} else {
			$this->update($feedInfo);
		}
	}
	
	private function insert($feedInfo){
		$firstItem = $this->getFirstItem($feedInfo);
		$sql = "INSERT INTO feed(url,title,link,last_id,last_maj,last_recup) VALUES (?,?,?,?,?,now())";
		$this->sqlQuery->query($sql, $feedInfo['url'],$feedInfo['title'],$feedInfo['link'],$firstItem['id_item'],$firstItem['pubDate']);
	}
	
	private function update($feedInfo){
		$sql = "UPDATE feed SET title=?, link= ?, last_id=?, last_maj=?,last_recup=now() WHERE url=?";
		$this->sqlQuery->query($sql,$feedInfo['title'],$feedInfo['link'],$feedInfo['id_item'],$feedInfo['pubDate'],$feedInfo['url']);
	}
	
	public function udpateLastRecup($url){
		$sql = "UPDATE feed SET last_recup=now() WHERE url=?";
		$this->sqlQuery->query($sql,$url);
	}
	
	public function getNext($id_f){
		$sql = "SELECT * FROM feed WHERE id_f > ? LIMIT 1";
		return $this->sqlQuery->queryOne($sql,$id_f);
	}
	
	/*public function getNb(){
		$sql = "SELECT count(*) FROM feed";
		return $this->sqlQuery->queryOne($sql);
	}
	
	public function pickOne(){
		$nb = $this->pickANumber();
		$sql = "SELECT * FROM feed WHERE id_f = (SELECT id_f FROM feed ORDER BY last_maj LIMIT $nb,1)";
		return $this->sqlQuery->queryOne($sql);	
	}
	
	private function pickANumber(){
		$nb_item = $this->getNb();
		$X =  mt_rand()/mt_getrandmax();
		$K =  $X * $nb_item * ($nb_item + 1 ) ;
		return floor(  (1 + sqrt(1 + 4 * $K)) / 2) - 1; 
	}*/
	
		

}
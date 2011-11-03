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
		$sql = "SELECT id_f FROM feed WHERE url=?";
		return $this->sqlQuery->queryOne($sql,$feedInfo['url']);
	}
	
	public function doUpdate($lastId, $feedInfo){
		if ($lastId == $feedInfo['id_item']) {
			$this->udpateLastRecup($feedInfo['url'],$feedInfo['lasterror']);
		} else {
			$this->update($feedInfo);
		}
	}
	
	public function insert($feedInfo){
		$sql = "INSERT INTO feed(url,title,link,last_id,last_maj,last_recup,etag,`last-modified`,item_title,item_link,item_content) VALUES (?,?,?,?,?,now(),?,?,?,?,?)";
		$this->sqlQuery->query($sql, $feedInfo['url'],$feedInfo['title'],$feedInfo['link'],$feedInfo['id_item'],$feedInfo['pubDate'],$feedInfo['etag'],$feedInfo['last-modified']
			,$feedInfo['item_title'],$feedInfo['item_link'],$feedInfo['item_content']
		);
		$sql = "SELECT id_f FROM feed WHERE url=?";
		return $this->sqlQuery->queryOne($sql,$feedInfo['url']);
	}
	
	private function update($feedInfo){
		$sql = "UPDATE feed SET title=?, link= ?, last_id=?, last_maj=?, etag = ? ,`last-modified` = ?, last_recup=now(),lasterror='', item_title=?, item_link=?,item_content=? WHERE url=?";
		$this->sqlQuery->query($sql,$feedInfo['title'],$feedInfo['link'],$feedInfo['id_item'],
			$feedInfo['pubDate'],$feedInfo['etag'],$feedInfo['last-modified'],
			$feedInfo['item_title'],$feedInfo['item_link'],$feedInfo['item_content'],$feedInfo['url']
			);
	}
	
	public function forceLastRecup($url){
		$sql = "UPDATE feed SET last_recup='1970-01-01' WHERE url=?";
		$this->sqlQuery->query($sql,$url);
	}
	
	public function udpateLastRecup($url,$error = ''){
		$sql = "UPDATE feed SET last_recup=now(),lasterror=? WHERE url=?";
		$this->sqlQuery->query($sql,$error,$url);
	}
	
	public function getNext($id_f){
		$sql = "SELECT * FROM feed WHERE id_f > ? LIMIT 1";
		return $this->sqlQuery->queryOne($sql,$id_f);
	}
	
	public function getFirstToUpdate(){
		$sql = "SELECT * FROM feed WHERE id_f= (SELECT id_f FROM feed ORDER BY last_recup LIMIT 1)";
		return $this->sqlQuery->queryOne($sql);
	}
	
	public function del($id_f){
		$sql = "DELETE FROM feed WHERE id_f=?";
		$this->sqlQuery->query($sql,$id_f);
	}
	
	public function feedInfo(){
		$info =  $this->sqlQuery->query("SELECT count(*) as nb, max(last_recup) as date FROM feed");	
		return $info[0];
	}
	
}
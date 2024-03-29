<?php
class FeedSQL extends SQL {
	
	private $feedItemSQL;
	
	public function __construct(SQLQuery $sqlQuery,FeedItemSQL $feedItemSQL){
		parent::__construct($sqlQuery);
		$this->feedItemSQL = $feedItemSQL;
	}
	
	public function getInfo($id_f){
		$sql = "SELECT feed.*,feed_item.title as item_title," .
				" feed_item.link as item_link,feed_item.description as item_description, " .
				" feed_item.id as item_id ". 
				" FROM feed " .
				" LEFT JOIN feed_item ON feed.last_id_i = feed_item.id_i  ".
				" WHERE feed.id_f = ? " ;
				
		return $this->queryOne($sql,$id_f);
	}
	
	public function getInfoFromURL($url){
		$sql = "SELECT * FROM feed WHERE url = ?";
		return $this->queryOne($sql,$url);
	}

	public function add(array $feedInfo){
		$infoFromDB = $this->getInfo($feedInfo['url']);
		if ($infoFromDB){
			$this->update($infoFromDB['last_id'] , $feedInfo);
		} else {
			$this->insert($feedInfo);
		}
		$sql = "SELECT id_f FROM feed WHERE url=?";
		return $this->queryOne($sql,$feedInfo['url']);
	}

	public function insert($feedInfo){
		$id_item = 0;
		$pubDate = '';
		if (isset($feedInfo['item'][0])){
			$id_item = $feedInfo['item'][0]['id_item'];
			$pubDate = $feedInfo['item'][0]['pubDate'];
		}
		
		$sql = "INSERT INTO feed(url,title,link,last_id,last_maj,last_recup,etag,`last-modified`,md5,favicon_update) VALUES (?,?,?,?,?,now(),?,?,?,?)";
		$this->query($sql, $feedInfo['url'],$feedInfo['title'],$feedInfo['link'],$id_item,$pubDate,
			$feedInfo['etag'],$feedInfo['last-modified'],
			$feedInfo['md5'],true
		);
		$sql = "SELECT id_f FROM feed WHERE url=?";
		$id_f = $this->queryOne($sql,$feedInfo['url']);
		return $id_f;
	}

	public function insertEmpty($url){
		$sql = "INSERT INTO feed(url,`last-modified`,title,link,last_maj,last_recup) " .
				" VALUES (?,'1970-01-01',?,?,'1970-01-01','1970-01-01') ";
		$this->query($sql,$url,$url,$url);
		$info = $this->getInfoFromURL($url);
		return $info['id_f'];
	}
	
	public function updateLastId($id_f,$last_id_i){
		$sql = "UPDATE feed SET last_id_i = ? WHERE id_f=?";
		$this->query($sql,$last_id_i,$id_f);
	}

	public function update($id_f,$feedInfo){
		$sql = "UPDATE feed " .
				" SET title=?, link= ?, last_id=?, last_maj=?, etag = ? ,`last-modified` = ?, last_recup=now(),lasterror='',md5=?," .
				" favicon_update=?" .
				"  WHERE id_f = ?";
		$this->query($sql,$feedInfo['title'],$feedInfo['link'],$feedInfo['item'][0]['id_item'],
			$feedInfo['item'][0]['pubDate'],$feedInfo['etag'],$feedInfo['last-modified'], 
			$feedInfo['md5'], true,
			$id_f
		);
		return true;
	}
	
	public function udpateLastRecup($url,$error = ''){
		$sql = "UPDATE feed SET last_recup=now(),lasterror=? WHERE url=?";
		$this->query($sql,$error,$url);
	}
	
	public function getNext($id_f){
		$sql = "SELECT * FROM feed WHERE id_f > ? LIMIT 1";
		return $this->queryOne($sql,$id_f);
	}
	
	public function getAllToUpdate($min_time){
		$sql = "SELECT id_f FROM feed WHERE last_recup < DATE_SUB(now(), INTERVAL $min_time SECOND) ";
		return $this->query($sql);
	}
	
	public function getFirstToUpdate(){
		$sql = "SELECT * FROM feed WHERE id_f= (SELECT id_f FROM feed ORDER BY last_recup LIMIT 1)";
		return $this->queryOne($sql);
	}
	
	public function del($id_f){
		$sql = "DELETE FROM feed WHERE id_f=?";
		$this->query($sql,$id_f);
	}
	
	public function feedInfo(){
		$info =  $this->query("SELECT count(*) as nb, max(last_recup) as max_date,min(last_recup) as min_date FROM feed");	
		return $info[0];
	}
	
	public function getAllFaviconToUpdate(){
		$sql = "SELECT id_f FROM feed WHERE favicon_update=?";
		return $this->query($sql,true);
	}
	
	public function updateFavicon($id_f,$favicon){
		$sql = "UPDATE feed SET favicon=?,favicon_update=? WHERE id_f=?";
		$this->query($sql,$favicon,0,$id_f);
	}
}
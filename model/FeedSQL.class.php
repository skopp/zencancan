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
		
		$sql = "INSERT INTO feed(url,title,link,last_id,last_maj,last_recup,etag,`last-modified`,favicon,md5) VALUES (?,?,?,?,?,now(),?,?,?,?)";
		$this->query($sql, $feedInfo['url'],$feedInfo['title'],$feedInfo['link'],$id_item,$pubDate,
			$feedInfo['etag'],$feedInfo['last-modified'],
			$feedInfo['favicon'], $feedInfo['md5']
		);
		$sql = "SELECT id_f FROM feed WHERE url=?";
		$id_f = $this->queryOne($sql,$feedInfo['url']);
	}
	
	public function updateLastId($id_f,$last_id_i){
		$sql = "UPDATE feed SET last_id_i = ? WHERE id_f=?";
		$this->query($sql,$last_id_i,$id_f);
	}

	public function update($id_f,$feedInfo){
		$sql = "UPDATE feed " .
				" SET title=?, link= ?, last_id=?, last_maj=?, etag = ? ,`last-modified` = ?, last_recup=now(),lasterror='',favicon=?,md5=?" .
				"  WHERE id_f = ?";
		$this->query($sql,$feedInfo['title'],$feedInfo['link'],$feedInfo['item'][0]['id_item'],
			$feedInfo['item'][0]['pubDate'],$feedInfo['etag'],$feedInfo['last-modified'], $feedInfo['favicon'],
			$feedInfo['md5'],
			$id_f
		);
		return true;
	}
	
	public function forceLastRecup($url){
		$sql = "UPDATE feed SET last_recup='1970-01-01' WHERE url=?";
		$this->query($sql,$url);
	}
	
	public function udpateLastRecup($url,$error = ''){
		$sql = "UPDATE feed SET last_recup=now(),lasterror=? WHERE url=?";
		$this->query($sql,$error,$url);
	}
	
	public function getNext($id_f){
		$sql = "SELECT * FROM feed WHERE id_f > ? LIMIT 1";
		return $this->queryOne($sql,$id_f);
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
	
}
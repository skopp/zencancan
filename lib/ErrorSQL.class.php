<?php


class ErrorSQL {
	
	
	public function __construct($sqlQuery){
		$this->sqlQuery = $sqlQuery;
	}
	
	public function add($search,$raison){
		$sql = "INSERT INTO error(search,date,raison) VALUES (?,now(),?)";
		$this->sqlQuery->query($sql,$search,$raison);
	}
	
}
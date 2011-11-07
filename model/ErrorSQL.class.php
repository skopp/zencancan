<?php
class ErrorSQL extends SQL {
	
	public function add($search,$raison){
		$sql = "INSERT INTO error(search,date,raison) VALUES (?,now(),?)";
		$this->query($sql,$search,$raison);
	}
	
}
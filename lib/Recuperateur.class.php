<?php 
class Recuperateur {
	
	private $tableauInput;
	
	public function __construct($tableauInput){
		$this->tableauInput = $tableauInput;
	}
	
	public function getInt($name,$default = 0){
		return intval($this->get($name,$default));
	}
	
	public function get($name,$default = false){
		if ( empty($this->tableauInput[$name])) {
			return $default;
		}
		$value = $this->tableauInput[$name];		
		if (get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}		
		return trim($value);
	}
}
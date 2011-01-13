<?php
class URLLoader {
	
	private $timeout;
	private $lastError;
	
	public function __construct($timeout = 5){
		$this->timeout = $timeout;
	}	
	
	public function getContent($url){
		
		$curl = curl_init($url);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl,CURLOPT_TIMEOUT,$this->timeout);
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );		
		
		$result =  curl_exec($curl);
		
		if ($result === false){
			$this->lastError = curl_error($curl);		
			return false;
		}
		
		$response = curl_getinfo($curl);				
					
		if ($response['http_code'] != 200){
			$this->lastError = "Erreur " . $response['http_code'];
			return false;
		}
		return $result; 				
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
}
<?php
class URLLoader {
	
	private $timeout;
	private $lastError;
	
	public function __construct($timeout = 5){
		$this->timeout = $timeout;
	}
	
	public function getContent($url,$eTag = false ,$lastModified = false,$acceptLanguage = false){
		if ( ! $url) {
			return false;
		}
		$curl = curl_init($url);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT,$this->timeout);
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );	

		$option = array();
		$option[] = "User-Agent: zencancan - (+http://zencancan.com/)";
		if ($eTag){
			$option[] = "If-None-Match: $eTag";
		}
		if ($lastModified){
			$option[] = "If-Modified-Since: $lastModified";
		}
		if ($acceptLanguage){
			$option[] = "Accept-Language: $acceptLanguage";
		}
	
		if ($option){
			curl_setopt( $curl, CURLOPT_HTTPHEADER, $option);
		}
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HEADERFUNCTION, array($this,"readHeader"));
		curl_setopt($curl, CURLINFO_HEADER_OUT, false); 
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
		
		$result = curl_exec($curl);
		
		if ($result === false){
			$this->lastError = curl_error($curl);		
			return false;
		}
		
		$response = curl_getinfo($curl);	
		
		if ($response['http_code'] == 304){
			$this->lastError = 304;
			return false;
		}
		
		if ($response['http_code'] != 200){
			$this->lastError = "Erreur " . $response['http_code'];
			return false;
		}
		return $result; 				
	}
	
	public function getLastError(){
		return $this->lastError;
	}
	
	public function getHeader($name){
		if (isset($this->lastHeader[$name])){
			return $this->lastHeader[$name];
		}
		return false;
	}
	
	private function readHeader($curl,$headerLine){
		if (preg_match("#([^:]+):\s*(.*)#",$headerLine,$matches)){
			$this->lastHeader[strtolower($matches[1])] = trim($matches[2]); 
		}
		return strlen($headerLine);
	}
	
}
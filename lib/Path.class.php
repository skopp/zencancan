<?php
class Path {
	
	private $site_index;
	private $username;
		
	public function __construct($site_index){
		$this->site_index = $site_index;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function path($to = ""){
		echo $this->getPath($to);
	}
	
	public function echoRessourcePath($absolute_path){
		echo substr( $this->getSiteIndex($this->username), 0,strrpos($this->getSiteIndex($this->username),"/")) . $absolute_path;
	}
	
	public function getPath($to = ""){		
		return $this->getPathWithUsername($this->username,$to);
	}
	
	public function getPathWithUsername($username="",$to = ""){
		return $this->getSiteIndex($username) . "$to";
	}
	
	private function getSiteIndex($username){
		if (! $username){
			return $this->site_index;
		}
		$parse_url = parse_url($this->site_index);
		$parse_url['host'] = "$username.{$parse_url['host']}"; 
		return $this->http_build_url($parse_url);
	}
	
	private function http_build_url($parse_url) {
		return 
			 ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
			.((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
			.((isset($parse_url['host'])) ? $parse_url['host'] : '')
			.((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
			.((isset($parse_url['path'])) ? $parse_url['path'] : '')
			.((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
			.((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
		;
	}	
}

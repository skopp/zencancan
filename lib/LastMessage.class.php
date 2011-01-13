<?php
class LastMessage {
	
	const ERROR = "error";
	const MESSAGE = "message";
	
	private $lastMessage;
	
	public function __construct(){
		$this->lastMessage =  array(false,"",array());
		if (isset($_SESSION['last_message'])){
			$this->lastMessage = $_SESSION['last_message'];
			unset($_SESSION['last_message']);
		}
	}
	
	public function setLastMessage($type,$message){
		$_SESSION['last_message'] = array($type,$message,$_POST);
	}
	
	public function getLastMessageType(){
		return $this->lastMessage[0];
	}
	
	public function getLastMessage(){
		return $this->lastMessage[1];
	}

	public function getLastInput($inputName,$defaultValue = ""){
		if (empty($this->lastMessage[2][$inputName])){
			return $defaultValue;
		}
		return htmlentities($this->lastPost[$inputName],ENT_QUOTES,"UTF-8");
	}	
}
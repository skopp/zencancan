<?php
class LastMessage {
	
	const ERROR = "error";
	const MESSAGE = "message";
	const INFO = "info";
	const NONE = "none";
	
	private $lastMessage;
	
	public function __construct(){
		
		$this->lastMessage =  array(false,"",array());
		if (isset($_SESSION['last_message'])){			
			$this->lastMessage = $_SESSION['last_message'];
			unset($_SESSION['last_message']);
		}
	}
	
	public function setLastInfo($message){
		$this->setMessage(self::INFO,$message);
	}
	
	public function setLastError($message,$secure = false){
		$this->setMessage(self::ERROR,$message,$secure);
	}
	
	public function setLastMessage($message,$secure = false){
		$this->setMessage(self::MESSAGE,$message,$secure);
	}
	
	private function setMessage($type,$message,$secure = false){
		$_SESSION['last_message'] = array($type,$message,$_POST,$secure);
	}
	
	public function setLastInput($data){
		$this->setMessage(self::NONE,"");
		$_SESSION['last_message'][2] = $data;
	}
	
	public function setInput($name,$value){
		$this->lastMessage[2][$name] = $value;
	}
	
	public function saveLastInput(){
		$this->setLastInput($this->lastMessage[2]);
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
		return htmlentities($this->lastMessage[2][$inputName],ENT_QUOTES,"UTF-8");
	}	
	
	private function getBox($type){
		$tabBox = array(self::ERROR => 'box_error',self::MESSAGE => 'box_confirm',self::INFO => 'box_info');
	}
	
	public function display(){
		if ( ! $this->getLastMessage()){
			return;
		}
		?>
		<p class='<?php hecho($this->getLastMessageType()==self::ERROR?'box_error':'box_confirm')?>'>
			<?php if ($this->lastMessage[3]) : ?>
				<?php echo($this->getLastMessage())?>
			<?php else : ?>
				<?php hecho($this->getLastMessage())?>
			<?php endif;?>
		</p>
		<?php 
	}
	
}
<?php 
class XMLPurifier {

	//See http://www.xmlsoft.org/html/libxml-xmlerror.html
	const XML_ERR_UNDECLARED_ENTITY = 26;
	
	private $undeclaredEntity;
	
	public function __construct(){
		libxml_use_internal_errors(true);
	}
	
	public function getTranslateEntity($entity){
		$transtable = array('&oelig;' => "&#156;");
		if (empty($transtable[$entity])){		
			trigger_error("Je n'ai pas trouvé de remplacant pour l'entité $entity");
			return "";
		}
		return $transtable[$entity];
	}
		
	private function tryLoad($content){		
		
		$xml = simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);		
		if ( ! $xml){
			$tab_error = libxml_get_errors();
			foreach($tab_error as $error){
				if ($error->code == self::XML_ERR_UNDECLARED_ENTITY){
					preg_match("#Entity '([^']*)' not defined#",$error->message,$matches);
					$this->undeclaredEntity[] = "&".$matches[1].";";
				} else {	
					trigger_error("Erreur lors de la lecture d'un fichier XML : " . $error->code . " - " . $error->message,E_USER_WARNING);
				}
			}
			libxml_clear_errors() ;
			return false;
		}
		return $xml->asXML();	
	}
	
	private function tr($content){
		foreach($this->undeclaredEntity as $entity){
			$trans[$entity] = $this->getTranslateEntity($entity);
		}
		return strtr($content, $trans);
	}
	
	function getXML($content){
		$xml = $this->tryLoad($content);
		if (! $xml && $this->undeclaredEntity){
			$content = $this->tr($content);
			$xml = $this->tryLoad($content);
		}
		return $xml;
	}


}
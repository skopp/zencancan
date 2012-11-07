<?php 

class ZenMail{
	
	const DEFAULT_CHARSET = 'UTF-8';
	
	
	private $destinataire;
	private $sujet;
	private $contenu;
	
	private $emmeteur;
	private $mailEmmeteur;
	
	private $charset;
	
	public function __construct(){
		$this->setCharset(self::DEFAULT_CHARSET);
	}
	
	public function setCharset($charset){
		$this->charset = $charset;
	}
	
	public function setEmmeteur($nom,$mail){
		$this->emmeteur = "$nom <$mail>";
		$this->mailEmmeteur = $mail; 
	}
	
	public function setDestinataire($destinataire){
		$this->destinataire = $destinataire;
	}
	
	public function setSujet($sujet){
		$this->sujet =  "=?utf-8?Q?".imap_8bit($sujet)."?=";
	}
	
	public function setContenu($script,$info){
		ob_start();
			include($script);
			$this->contenu = ob_get_contents();
		ob_end_clean();
	
	}	
	
	public function send(){
		assert('$this->emmeteur');
		assert('$this->mailEmmeteur');
		assert('$this->destinataire');
		assert('$this->sujet');
		assert('$this->contenu');		
		
		$entete =	"From: ".$this->emmeteur."\r\n".
					"Reply-To: ".$this->mailEmmeteur."\r\n".
					"Content-Type: text/plain; charset=\"".$this->charset."\"";		
		
		
    	mail($this->destinataire,$this->sujet,$this->contenu,$entete);
   
	}	
    
}
<?php

$content = file_get_contents("http://www.filosofiagames.com/filosofia-rss.php");

class XMLPurifier {

	//See http://www.xmlsoft.org/html/libxml-xmlerror.html
	const XML_ERR_UNDECLARED_ENTITY = 26;
	
	public function __construct(){
		libxml_use_internal_errors(true);
	}
	
	public function getTranslationTable(){
		$trans = array_flip(get_html_translation_table(HTML_SPECIALCHARS));
		
	}
		
	private function tryLoad($content){		
		$xml = simplexml_load_string($content);
		if (!$xml){
			$tab_error = libxml_get_errors();
			foreach($tab_error as $error){
				if ($error->code == self::XML_ERR_UNDECLARED_ENTITY){
					preg_match("#Entity '([^']*)' not defined#",$error->message,$matches);
					$this->undeclaredEntity[] = $matches[1];
				}	
			}
			libxml_clear_errors() ;
		}	
	}
	
	function getXML($content){
		$xml = $this->tryLoad($content);
		if (! $xml && $this->undeclaredEntity){
			
		}
	}


}


$xmlPurifier = new XMLPurifier();
echo $xmlPurifier->getXML($content);

#$content = file_get_contents("http://www.jeanmarcmorandini.com/rss.php");

#$content = "<d>&eacute;</d>";

$trans = array_map('utf8_encode', 
	array_flip(array_diff(get_html_translation_table(HTML_ENTITIES), get_html_translation_table(HTML_SPECIALCHARS))));
//print_r($trans);

/*unset($trans['&lt;']);
unset($trans['&gt;']);	
$trans['&oelig;'] ='&#156;';*/

//$content1 = strtr($content, $trans);




/*$z = new XMLReader;

$z->xml($content);
$z->setParserProperty(XMLReader::SUBST_ENTITIES , false);

$doc = new DOMDocument;

// move to the first <product /> node
while ($z->read() && $z->name !== 'rss');

$node = simplexml_import_dom($doc->importNode($z->expand(), true));

echo $node->asXML();
*/
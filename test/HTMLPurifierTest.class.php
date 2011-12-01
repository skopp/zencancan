<?php

require_once('simpletest/autorun.php');
require_once(__DIR__ . "/../lib/HTMLPurifier.class.php");

class HTMLPurifierTest extends UnitTestCase {

	private function doTest($input, $expected){
		$htmlPurifier = new HTMLPurifier();			
		$chaine_purifie = $htmlPurifier->purify($input);		
		$this->assertEqual($chaine_purifie,$expected);		
	}
	
	private function doNotModified($input){
		$this->doTest($input,$input);
	}
	
	public function testEmpty(){
		$this->doNotModified("");
	}

	public function testWord(){
		$this->doNotModified("toto");
	}
	
	public function testSafeTag(){
		$this->doNotModified("<p>toto</p>");
	}
	
	public function testUnexpectedTag(){
		$this->doTest("<toto>test</toto>","<!--tag removed :toto-->test<!--end tag removed toto-->");
	}
	
	public function testNeestedTag(){
		$this->doNotModified("<p><span>test</span></p>");
	}
	
	public function testNeestedUnexpetcedTag(){
		$this->doTest("<p><script>test</script></p>","<p><!--tag removed :script-->test<!--end tag removed script--></p>");
	}
	public function testNeestedTagUnexcpeted(){
		$this->doTest("<script><p>test</p></script>","<!--tag removed :script--><p>test</p><!--end tag removed script-->");
	}
	
	public function testAuthorizedAttribut(){
		$this->doNotModified('<a href="toto">toto</a>');
	}
	
	public function testUnauthorizedAttribut(){
		$this->doTest('<a onclick="toto">toto</a>','<a>toto</a>');
	}
	
	public function testExternalEntity(){
		$this->doNotModified("test &#8217; toto");
	}
	
	public function testNotAnEntity(){
		$this->doNotModified('<a href="?a=1&b=2">test</a>');
	}
	
	public function testComment(){
		$this->doTest('<!-- commentaire -->',"");
	}
	
	public function testNoAttribut(){
		$this->doTest('<a onclick="toto" c="d">toto</a>','<a>toto</a>');
	}

	public function testPlusOne(){
		$this->doTest("<g:plusone/>","<!--tag removed :plusone--><!--end tag removed plusone-->");
	}
	
	public function test2Tag(){
		$this->doNotModified("<p>a</p><p>b</p>");
	}
	
	public function testError1(){
		$this->doTest('<a href=\"b\" />','<a href="\&quot;b\&quot;"/>');
	}
	
	public function testLong(){
		$this->doNotModified('<span style="text-decoration: underline"><img style="border-bottom: 0px; border-left: 0px; margin: 0px 15px 0px 0px; display: inline; border-top: 0px; border-right: 0px" title="Another Earth" border="0" alt="Another Earth" align="left" src="http://www.anglesdevue.com/wp-content/uploads/2011/10/AnotherEarth.jpg" width="178" height="237" /> Another Earth        <br /></span></strong><em>Another Earth&#160; <br /></em>    <br />Réalisateur : Mike Cahill&#160; <br />Avec : Brit Marling, William Mapother, Meggan Lennon,     <br />Matthew-Lee Erlbach, Jordan Baker, Flint Beverage    <br />Origine : Etats-Unis     <br />Genre : Science-fiction intimiste&#160; <br />Durée : 1h32     <br />Date de sortie France : 12/10/2011     <br />Note pour ce film : <span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="color: #400040"><span style="color: #400040"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="color: #400040"><span style="color: #400040"><span><span style="font-size: x-large"><span style="font-family: microsoft sans serif"><span style="color: #b6565f"><span><span style="color: #400040"><span style="color: #b6565f; font-size: 20pt">●</span><span style="color: #b6565f; font-size: 20pt">●</span><span style="color: #b6565f; font-size: 20pt">●</span><span style="color: #b6565f; font-size: 20pt">●<span style="color: #b6565f; font-size: 20pt"><span style="color: #400040">○</span></span></span><span style="color: #400040">○</span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span></span>');
	}
	

	
	
}

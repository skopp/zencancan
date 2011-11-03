<?php
class RSSControler extends ZenCancanControler {
	
	public function allAction($id,$tag=""){
		
		$rssCreator = new RSSCreator("zenCancan - flux $id","Flux pour l'id $id",   $this->Path->getPath() );

		$allFlux = $this->AbonnementSQL->getWithContent($id,0,$tag);

		foreach($allFlux as $flux){
			$rssCreator->addItem($flux['title'] . ": " .$flux['item_title'],$flux['item_link'],$flux['last-modified'],$flux['item_content']);
		}

		echo $rssCreator->getRSS();
	}
	
}
<?php
class SuivantPrecedent {
	
		private $url;
		private $offset;
		private $limit;
		private $nbTotal;
		
	
		public function setParameter($offset,$limit,$nbTotal,$url){
			assert('$limit != 0');
			$this->offset = $offset;
			$this->limit = $limit;
			$this->nbTotal = $nbTotal;
			$this->url = $url;
		}
	
		private function echoLink($offset){
			printf($this->url,$offset);
		}
		
		public function display() {		
			if ($this->nbTotal < $this->limit ){
				return;
			}
			
			$pageMax = ceil($this->nbTotal / $this->limit);
			$thisPage = ($this->offset / $this->limit) + 1;
			
			$allPage= range(max(1,$thisPage - 2) , min($pageMax,$thisPage +2));
			$allPage[] = 1;
			$allPage[] = $pageMax;
			sort($allPage);
			
			$allPage = array_unique($allPage);
			
			
			$old_page = 0;
			?>
		<div class="box_suiv">			
			<?php if ( $this->offset) : ?>
				<a href="<?php $this->echoLink( $this->offset-$this->limit) ?>"><?php echo _("Précédent") ?></a>
			<?php endif; ?>
			<?php foreach($allPage as $page ): ?>
				<?php if ($old_page+1 != $page): ?>
					<span class='dots'>...</span>
				<?php endif;?>		
				<?php $old_page = $page; ?>	
				<?php if ($page == $thisPage) : ?>
					<span class='page_number this_page'><?php echo $page ?></span>
				<?php else : ?>
					<a class='page_number' href='<?php $this->echoLink( $this->limit * ($page  -1)) ?>'><?php echo $page ?></a>
				<?php endif;?>
			<?php endforeach;?>
		 	<?php if(($this->offset+$this->limit) < $this->nbTotal) : ?>
		 		<a href="<?php $this->echoLink($this->offset+$this->limit ) ?>"><?php echo _("Suivant") ?></a>
			<?php endif; ?>
		</div>
		<?php
		} 
	
	
}
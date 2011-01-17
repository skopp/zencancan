<?php


class Paginator {
	
	private $nbTotal;
	
	public function __construct($nbTotal,$nbAfficher,$offset){
		$this->nbTotal = $nbTotal;
		$this->nbAfficher = $nbAfficher;
		$this->offset = $offset;
	}
	
	public function setLink($link){
		$this->link=$link;
	}
	
	public function displayPrevious($text){
		if ($this->offset + $this->nbAfficher >= $this->nbTotal){
			return;
		}
		?>
		<a href='<?php echo $this->link ?>&offset=<?php echo $this->offset + $this->nbAfficher ?>'>	
			<?php echo $text ?>
		</a>
		<?php 
	}
	
	public function displayNext($text){
		if (! $this->offset){
			return;
		}
		?>
		<a href='<?php echo $this->link ?>&offset=<?php echo max(0,$this->offset - $this->nbAfficher) ?>'>	
			<?php echo $text ?>
		</a>
		<?php 
	}
	
	
}
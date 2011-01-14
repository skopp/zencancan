<?php
class FancyDate {
	
	public function get($date_iso){
		$time = strtotime($date_iso);
		$now = time();
		
		$nb_jour = (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",$time))) / 86400;
			
		if ($nb_jour == 1 ){
			return "Hier à ". date("H:i",$time);
		}
		if ($nb_jour > 6){
			$result = strftime("%e %B",$time);
			if (date("Y") != date("Y",$time)){
				$result.=" ".date("Y",$time);
			}
			return $result ; 
		}
		if ($nb_jour > 1){
			return ucfirst(strftime("%A, %H:%M",$time)); 
		}
		
		return date("H:i",$time);
	}
	
}
<?php


function hecho($txt,$quotes = ENT_QUOTES ){
	echo htmlentities($txt,$quotes,"UTF-8");
}

function wrap($txt,$line_length,$nb_line){
	if (strlen($txt)<$line_length * $nb_line){
		return $txt;
	}
	$result = "";
	$ln_line = 0;
	$ww = explode(" ",$txt);
	foreach ($ww as $word){
		$result.=$word." ";
	
		if ($ln_line + strlen($word) > $line_length){
			$nb_line--;
			$ln_line = 0;
			if (! $nb_line  ){
				return $result ."...";
			}
			if ($nb_line == 1){
				$line_length -= 4;
			}
		}
		$ln_line += strlen($word) + 1;
	}
	return $result;
}

function get_link_title($content){
	
	$content = html_entity_decode(strval($content),ENT_QUOTES,"UTF-8");
	return htmlentities(trim(wrap(strip_tags($content),200,1)),ENT_QUOTES,"UTF-8");
}

function display_requete_info(){ ?>

Requête genéré par : 

IP : <?php echo $_SERVER['REMOTE_ADDR'] ?>

Date : <?php echo date("Y-m-d h:i:s");?>

URL: <?php echo "http://".$_SERVER['SERVER_NAME']."/" . $_SERVER['REQUEST_URI'] ?>
<?php 
}


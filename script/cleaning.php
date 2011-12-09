<?php 

//Vérifie que les images des répetoire img et favicon sont dans la base
//Les supprimes sinon

require_once( __DIR__ ."/../init.php");

$sql = "SELECT count(*) FROM feed WHERE favicon=?";
deleteIfNeeded( $objectInstancier->favicon_path ,$sql);

$sql = "SELECT count(*) FROM feed_item WHERE img=?";
deleteIfNeeded( $objectInstancier->img_path ,$sql);


function deleteIfNeeded($dir,$sql){
	global $objectInstancier;
	$dh  = opendir($dir);
	while (($file = readdir($dh)) !== false) {
			if (is_file($dir . "/" . $file)){
				if (! $objectInstancier->SQLQuery->queryOne($sql,$file)){
					echo "DELETE $file\n";
					unlink($dir."/".$file);
				}
			}           
	}	
}
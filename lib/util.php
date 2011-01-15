<?php


function hecho($txt,$quotes = ENT_QUOTES ){
	echo htmlentities($txt,$quotes,"UTF-8");
}
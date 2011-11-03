<?php
require_once(__DIR__."/lib/HTMLPurifier.class.php");

$HTMLPurifier = new HTMLPurifier();


echo $HTMLPurifier->purify("<table/><iframe toto='12'></iframe>");

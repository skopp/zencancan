<?php
require_once( __DIR__."/../init-web.php");

$authentification->logout();
header("Location: index.php");
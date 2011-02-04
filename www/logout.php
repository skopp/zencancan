<?php
require_once( __DIR__."/../init-web.php");

$compte->deleteRemember($id);
setcookie("remember_zencancan","");
$authentification->logout();
header("Location: index.php");
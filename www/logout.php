<?php
require_once( __DIR__."/../init-web.php");

setcookie("id","");
session_destroy();
header("Location: index.php");
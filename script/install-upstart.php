#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");

$php_path = `which php`;
$php_path = trim($php_path);

$log_path = "/var/log/zencancan.log";

$deamon_path = __DIR__ ."/feed_update.php";

$content = <<<"UPSTART"
description "Zencancan Daemon Upstart Script"

start on started mysql
stop on stopping mysql

respawn

exec sudo -u www-data $php_path $deamon_path >> $log_path

UPSTART;


file_put_contents("/etc/init.d/zencancan.conf",$content);



#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");

$php_path = `which php`;
$php_path = trim($php_path);

$log_path = "/var/log/zencancan.log";

$deamon_path = __DIR__ ."/feed_update.php";
$deamon_image_path = __DIR__. "/image_update.php";


$content = <<<"UPSTART"
description "Zencancan Daemon Upstart Script"

start on started mysql
stop on stopping mysql

respawn

exec sudo -u www-data $php_path $deamon_path >> $log_path 2>&1

UPSTART;

file_put_contents("/etc/init/zencancan.conf",$content);


$content = <<<"UPSTART"
description "Zencancan Image Daemon Upstart Script"

start on started zencancan
stop on stopping zencancan

respawn

exec sudo -u www-data $php_path $deamon_image_path >> $log_path 2>&1

UPSTART;

file_put_contents("/etc/init/zencancan_image.conf",$content);


$content = <<<"LOGROTATE"
/var/log/zencancan.log
{
	rotate 7
	daily
	missingok
	notifempty
	delaycompress
	compress
	postrotate
		restart zencancan >/dev/null 2>&1 || true
	endscript
}
LOGROTATE;
file_put_contents("/etc/logrotate.d/zencancan",$content);

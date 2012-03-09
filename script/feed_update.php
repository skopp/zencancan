#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");

$objectInstancier->FeedUpdater->updateOnce($objectInstancier->AbonnementSQL);
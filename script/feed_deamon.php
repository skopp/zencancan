#! /usr/bin/php
<?php
require_once( __DIR__ ."/../init.php");



$objectInstancier->FeedUpdater->updateForever($objectInstancier->AbonnementSQL,LOG_FILE);



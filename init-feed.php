<?php

require_once("URLLoader.class.php");
$urlLoader = new URLLoader();

require_once("GoogleSearch.class.php");
$googleSearch = new GoogleSearch($urlLoader);
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	$googleSearch->setHTTPAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
}

require_once("FeedParser.class.php");
$feedParser = new FeedParser();

require_once("FeedFetchInfo.class.php");
$feedFetchInfo = new FeedFetchInfo($urlLoader,$feedParser,$googleSearch);


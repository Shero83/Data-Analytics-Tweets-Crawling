<?php 
include 'pipe.php';
header('content-type: text/xml');
error_reporting(E_ERROR | E_PARSE);
$urls = array('https://twitter.com/DimensionVtweet/lists/data-influencers');
echo main($urls, 'twt');
?>
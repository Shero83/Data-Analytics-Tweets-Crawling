<?php	
	$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
</rss>
XML;

$keywords = array('data', 'bigdata', 'analytics', 'sql', 'visualization', 'dataviz', 'infographic', 'tableau', 'hadoop');

$block = array('@', ' rt ', ' rt:', 'retweet');

$sRegex = array('/data/i', '/analytics/i', '/sql/i', '/visualization/i', 
'/data ?viz/i', '/infographic/i', '/data ?science/i', '/big( |#| #)?data/i', '/(^| )R( |$|,|\.|\?|\!|:)/', '/python/i',  '/hadoop/i', '/tableau/i', '/hadoop/i', '/##/', '/&amp;/');

$dRegex = array('#Data', '#Analytics', '#SQL', '#Visualization', 'DataViz', '#Infographic', 'DataScience', '#BigData', ' #R ', '#Python', '#Hadoop', '#Tableau', '#Hadoop', '#', '&');
?>
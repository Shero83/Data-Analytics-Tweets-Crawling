<?php 
include 'pipe.php';
header('content-type: text/xml');
error_reporting(E_ERROR | E_PARSE);
$urls = array(
'http://www.techrepublic.com/rssfeeds/blog/big-data-analytics/',
'http://feeds.feedburner.com/ResourcesDiscussions-DataScienceCentral',
'http://feeds.feedburner.com/ResearchDiscussions-DataScienceCentral?format=xml',
'http://feeds.feedburner.com/ibm-big-data-hub-infographics?format=xml',
'http://feeds.feedburner.com/ibm-big-data-hub-videos?format=xml',
'http://feeds.feedburner.com/AnnouncementsDiscussions-DataScienceCentral?format=xml',
'http://feeds.feedburner.com/FeaturedPosts-Hadoop360?format=xml',
'http://feeds.feedburner.com/FeaturedPosts-Dataviz?format=xml',
'http://feeds.feedburner.com/FeaturedBlogPosts-DataScienceCentral?format=xml',
'http://feeds.feedburner.com/AnalyticsCoursesDiscussions-Analyticbridge?format=xml',
'http://feeds.feedburner.com/FeaturedBlogPosts-Bigdatanews?format=xml',
'http://data-ink.com/?feed=rss2',
'http://feeds.feedburner.com/InformationIsBeautiful',
'http://feeds.infosthetics.com/infosthetics.com',
'http://feeds.feedburner.com/gislounge',
'http://feeds.feedburner.com/DataMining',
'http://blogs.wsj.com/numbers/feed/',
'http://feeds.feedburner.com/BasketballGeek',
'http://junkcharts.typepad.com/junk_charts/atom.xml',
'http://feeds2.feedburner.com/peltiertech/EsrO',
'http://feeds2.feedburner.com/ChartPorn',
'http://feeds.feedburner.com/visualcomplexity',
'http://datavisualization.ch/feed/',
'http://makingmaps.net/feed/',
'http://neoformix.com/index.xml',
'http://feeds.infosthetics.com/infosthetics.com'
);
echo main($urls, 'rss');
?>
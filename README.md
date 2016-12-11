## Data-Analytics-Tweets-Crawling

Collect top tweets about data analytics. This project replaces a Yahoo pipe that I had running before Yahoo decided to discontinue the pipes project.

The pipe.php file runs using a cron job every hour. It attempts to search for specific keywords (those in pipeData.php) within the RSS and Twitter feeds specified in rss.php and twt.php respectivley. 

I use the output of this pipe along with [IFTTT](https://ifttt.com/) to automatically post newly matching tweets to [@DimensionVTweets](https://twitter.com/DimensionVtweet)

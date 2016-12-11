<?php
// Remove tags
function removeTags($str)
{
    $index = strpos($str, '>');
    $result = '';
    while ($index !== false)
    {
        $str = substr($str, $index+1);
        if (strlen($str) > 1)
            $result = $result . substr($str, 0, strpos($str, '<'));
        $index = strpos($str, '>');
    }
    $result = preg_replace('/http(\S)+/i', '', $result);
    return preg_replace('/pic.tw(\S)+/i', '', $result);

}

// Comparison function
function cmp($a, $b)
{
    $a = strtotime($a->pubDate);
    $b = strtotime($b->pubDate);
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

// Filter feeds
function filter($item, $words)
{
    foreach ($words as $word) {
        if (strpos(strtolower($item->title->__toString()), $word) !== false)
            return true;
    }
    return false;
}

// Ftech + Union + Unique
function fetchFeed($source, $type, &$destination)
{
    include 'pipeData.php';
    try {
        if ($type == 'rss') {
            $items = (new SimpleXmlElement(file_get_contents($source), LIBXML_NOCDATA));
            if(isset($items->channel)) {$items = $items->channel->item; $flag='xml';}
            if(isset($items->entry)) {$items = $items->entry; $flag = 'atom';}
        } elseif ($type == 'twt') {
//TWITTER
            $doc = new DOMDocument();
            $doc->loadHTMLFile($source);
            $node = $doc->getElementById('stream-items-id');

            $items = (new SimpleXmlElement($doc->saveXML($node), LIBXML_NOCDATA));
            $items = $items->xpath("//div[@class='content']");
            $flag = 'twt';
        }

        foreach ($items as $item) {
            $valid = false;
            if ($flag == 'xml' && isset($item->link) && isset($item->title) && isset($item->pubDate))
            {
                $valid = true;
                $item->myLink = $item->link;
            }
            elseif ($flag == 'atom' && isset($item->link[0]) && isset($item->title) && isset($item->updated))
            {
                $valid = true;
                $item->pubDate = $item->updated;
                $tmp = $item->link[0]->attributes();
                $item->myLink = $tmp['href'];
            }
            elseif ($flag == 'twt')
            {
                // Set the title
                $t = $item->xpath("./p[@class='TweetTextSize  js-tweet-text tweet-text']");
                $item->title = removeTags($t[0]->asXML());

                if (!filter($item, $block))
                {
                    // Set the link
                    $ls = $item->xpath("./p[@class='TweetTextSize  js-tweet-text tweet-text']/a");
                    foreach($ls as $l)
                    {
                        $t = $l->attributes();
                        $tmpLink = $t['href'];
                        if(strpos($tmpLink, 'http') !== false) {
                            $item->myLink = $tmpLink;
                            $valid = true;
                        }
                    }
                    // Set the pubDate
                    $t = $item->xpath("./div/small/a/span");
                    $t = $t[0]->attributes();
                    $s = (new DateTime('@' . $t['data-time']));
                    $item->pubDate = $s->format('c');
                }
            }

            if ($valid && filter($item, $keywords)) {
                if (array_key_exists($item->myLink->__toString(), $destination) && strtotime($item->pubDate) < strtotime($destination[$item->myLink->__toString()]->pubDate)) {
                } else {
                    $item->title = preg_replace($sRegex, $dRegex, $item->title);
// Truncate string to 115 in length
                    $str = $item->title->__toString();
                    if (strlen($str) > 115) {
                        $item->title = substr($str, 0, 115);
                    }
                    $destination[$item->myLink->__toString()] = $item;
                }
            }
        }

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

// Main program
function main($urls, $type)
{
    include 'pipeData.php';
    date_default_timezone_set('America/Los_Angeles');

    $feed = new SimpleXmlElement($xmlstr);
    $channel = $feed->addChild('channel');
    $channel->addChild('title', 'DimensionV Data Source Feed');
    $channel->addChild('link', 'http://dimensionv.com');
    $channel->addChild('description', 'DimensionV Data Source Feed');
    $channel->addChild('language', 'en-us');
    $channel->addChild('copyright', 'Copyright (C) 2015 dimensionv.com');

    $worker = array();
    foreach ($urls as $url) {
        fetchFeed($url, $type, $worker);
    }

// Sort worker array
    uasort($worker, 'cmp');

    foreach ($worker as $item) {
        $tmp = $channel->addChild('item');
        $tmp->title = $item->title;
        $tmp->link = $item->myLink;
        $tmp->pubDate = $item->pubDate;
    }
    return $feed->asXML();
}
?>
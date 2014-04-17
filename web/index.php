<?

##############################################################################
# Requires
##############################################################################

// generic libs
require_once 'utils.php';
require_once 'random.php';
require_once 'words.php';

// app-specific
require_once 'feed_utils.php';

$interval = get('interval', ['default'=>10]);
$latest_time = get('time', ['default'=>time()]); # time of latest post
$feed_title = get('feed_title', ['default' => 'My Delightful Feed']);
$title_prefix = get('title_prefix', ['right_padding_if_present' => ' ']);
$feed_image = get('feed_image'); // e.g. http://www.unity.fm/rssfeeds/ACourseInMiracles
$feed_img = get('feed_img'); // e.g. http://feeds.feedburner.com/takeawaymoviedate
$description_prefix = get('description_prefix', ['right_padding_if_present' => ' ']);
$explicit = filter_var(get('explicit', ['default' => 'false']), FILTER_VALIDATE_BOOLEAN);
$itunes = filter_var(get('itunes', ['default' => 'true']), FILTER_VALIDATE_BOOLEAN);

$explicit_string = $explicit ? 'yes' : 'no';
$latest_time = floor($latest_time/$interval) * $interval;
date_default_timezone_set('UTC');

include 'feed.php'
?>

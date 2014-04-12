<?

##############################################################################
# Requires
##############################################################################

require_once 'words.php';
require_once 'random.php';

##############################################################################
# Functions
##############################################################################

function toBase($num) { return base_convert($num, 10, 36); }
function to10( $num) { return base_convert($num, 36, 10); }

function post_time($index) {
  global $interval, $latest_time;
  $time = $latest_time - $index * $interval;
  return $time - $time % $interval;
}

function time_string($index) {
  $post_time = post_time($index);
  #$rounded = $post_time - $post_time % 10;
  return date("H:i:s",$rounded) . " on " . date("jS", $rounded) . " of " . date("M", $rounded) . ", " . date("Y", $rounded);
}

function guid($index) {
  //return base64_encode(post_time($index));
  return toBase(post_time($index));
}

function sample($array) {
  $index = Random::num(0, count($array)-1);
  return $array[$index];
  #return $index;
}

function phrase($index) {
  global $adjectives, $animals, $countries;
  Random::seed(post_time($index));
  #mt_srand(post_time($index));
  #Random::seed(post_time($index));
  return sprintf("%s %s in %s", sample($adjectives), sample($animals), sample($countries));
}

function mp3($title) {
  $query = preg_replace('/\s+/', '+', $title);
  return "http://tts-api.com/tts.mp3?q=" . $query;
}

function image($index) {
  return 'http://player.fm/assets/logos/playerwide-lightx40.png'; // hard-coded for now
}

function keywords($index) {
  return "wow,much,cake,many,crum,yum"; #hardcoded
}

// http://css-tricks.com/snippets/php/get-current-page-url/
function self_url() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] !== "80" ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return urlencode($url);
}

function pubDate($index) {
  return date('D, d M Y H:i:s O', post_time($index));
}

##############################################################################
# Init
##############################################################################

function get($param_key, $options=array()) {
  $options = array_merge([
    'default' => '',
    'left_padding' => '',
    'right_padding' => '',
    'right_padding_if_present' => '',
  ], $options);
  $val = isset($_GET[$param_key]) ? $_GET[$param_key] : $options['default'];
  $val = $options['left_padding'] . $val . $options['right_padding'];
  $val = $val . (strlen($val) > 0 ? $options['right_padding_if_present'] : '');
  return $val;
}

$interval = get('interval', ['default'=>10]);
$latest_time = get('time', ['default'=>time()]); # time of latest post
$title_prefix = get('title_prefix', ['right_padding_if_present' => ' ']);
$explicit = filter_var(get('explicit', ['default' => 'false']), FILTER_VALIDATE_BOOLEAN);
$explicit_string = $explicit ? 'yes' : 'no';
$description_prefix = get('description_prefix', ['right_padding_if_present' => ' ']);
$latest_time = floor($latest_time/$interval) * $interval;
date_default_timezone_set('UTC');

##############################################################################
# Initial content
##############################################################################

header("Content-Type: application/rss+xml");
echo <<<END
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" media="screen"
  href="/~d/styles/rss2enclosuresfull.xsl"?><?xml-stylesheet type="text/css"
  media="screen"
  href="feed.css"?>
END;

?>

<rss xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
  version="2.0">
  <channel>

    <title>My Delightful Feed</title>
    <link><?= self_url() ?></link>
    <description>It's been said this is the most sublime feed any human has ever beared witness to. Who am I to argue?</description>
    <language>en-us</language>
    <lastBuildDate><?= pubDate(0) ?></lastBuildDate>
    <pubDate><?= pubDate(0) ?></pubDate>
    <ttl>600</ttl>
    <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="<?= self_url() ?>" />
    <media:copyright>(c) Nuvomondo Ltd</media:copyright>
    <media:thumbnail url="<?= image(-1) ?>" />
    <media:keywords><?= keywords(-1) ?></media:keywords>
    <media:category scheme="http://www.itunes.com/dtds/podcast-1.0.dtd">Society &amp; Culture</media:category>
    <itunes:author>Stephen J. Dubner and Sooty the Teddy Bear</itunes:author>
    <itunes:explicit><?= $explicit_string ?></itunes:explicit>
    <itunes:image href="<?= image(-1) ?>" />
    <itunes:keywords><?= keywords(-1) ?></itunes:keywords>
    <itunes:subtitle>Really quite an astonishing contribution to humanity and the finer arts</itunes:subtitle>
    <itunes:category text="Society &amp; Culture" />

    <? for ($index = 1; $index <= 5; $index++) { ?>
      
      <!-- Item <?= $index ?> -->

      <item>
        <title><?= $title_prefix ?><?= ucfirst($title = phrase($index, true)) ?></title>
        <link>http://<?= $_SERVER['HTTP_HOST'] ?>/dynamic/<?= guid($index) ?></link>
        <description><?= $description_prefix ?>Comparing <?= phrase($index) ?> to <?= phrase($index+1) ?></description>
        <pubDate><?= pubDate($index) ?></pubDate>
        <language>en-us</language>
        <guid isPermaLink="false">http://<?= $_SERVER['HTTP_HOST'] ?>/<?= guid($index) ?></guid>
        <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">Humphrey B. Bear</dc:creator>
        <media:content url="<?= mp3($index) ?>" type="audio/mpeg" />
        <ttl>600</ttl>
        <itunes:explicit><?= $explicit_string ?></itunes:explicit>
        <itunes:subtitle>My reflections</itunes:subtitle>
        <itunes:author>Humphrey B. Bear</itunes:author>
        <itunes:summary>About <?= $title ?></itunes:summary>
        <itunes:keywords><?= keywords($index) ?></itunes:keywords>
        <enclosure url="<?= mp3($title) ?>" type="audio/mpeg" />
      </item>

    <? } ?>

    <copyright>(c) Nuvomondo Ltd</copyright>
    <media:credit role="author">Humphrey B. Bear</media:credit>
    <media:rating>nonadult</media:rating>

  </channel>
</rss>

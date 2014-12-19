<?php
##############################################################################
# Functions
##############################################################################

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

function mp3($media_scheme_prefix, $title) {
  $query = preg_replace('/\s+/', '+', $title);
  return $media_scheme_prefix . "//tts-api.com/tts.mp3?q=" . $query;
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

?>

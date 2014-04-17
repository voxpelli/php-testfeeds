<?php

require_once 'utils.php';

global $etag, $name;

function server($key, $default=null) {
  return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
}

function get($param_key, $default=null) {
  return isset($_GET[$param_key]) ? $_GET[$param_key] : $default;
}

function limit($min, $val, $max) {
  return max($min, min($val, $max));
}

function response_headers() {

  global $etag, $name;
  $etag_spec = get('etag', sha1($name));
  if ($etag_spec!='_') {
    $etag = '"' . $etag_spec . '"';
    header('Etag: ' . $etag);
  }

  #$last_modified_time = new DateTime('2014-02-8 08:30:00', new DateTimeZone('UTC'));
  $epoch_secs = get('last_modified', 1391848200);
  if ($epoch_secs!='_') {
    $last_modified_time = new DateTime("@$epoch_secs");
    $time_format = 'D, d M Y H:i:s O';
    header('Last-Modified: ' . $last_modified_time->format($time_format));
  }
  return;

}

$name = preg_replace("/[^a-zA-Z0-9.]+/", "", get('name', 'freakowild'));
$file = './media/' . $name;
$fp = fopen($file, 'rb');

$type_spec = get('type', 'true');
if ($type_spec!='_') {
  if ($type_spec=='true') {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file);
    finfo_close($finfo);
  } else {
    $mime_type = urldecode($type_spec);
  }
  header("Content-Type: " . $mime_type);
}

$length_spec = get('length', 'true');
if ($length_spec!='_') {
  if ($length_spec=='true') {
    header("Content-Length: " . filesize($file));
  } else {
    header("Content-Length: " . $length_spec);
  }
}

$pre_delay = limit(0, intval(get('predelay', '0')), 60);
$post_delay = limit(0, intval(get('postdelay', '0')), 60);

response_headers();

//print($etag);
//print(server('HTTP_IF_NONE_MATCH'));

sleep($pre_delay);
if ($etag && $etag==server('HTTP_IF_NONE_MATCH')) {
   header('HTTP/1.0 304 Not Modified');
} else {
  fpassthru($fp);
}
sleep($post_delay);

fclose($fp);

?>

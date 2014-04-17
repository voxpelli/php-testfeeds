<?php

require_once 'utils.php';

global $etag, $last_modified_time, $formatted_last_modified_time, $name;
function response_headers() {

  global $etag, $last_modified_time, $formatted_last_modified_time, $name;
  $etag_spec = get('etag', ['default'=>sha1($name)]);
  if ($etag_spec!='_') {
    $etag = '"' . $etag_spec . '"';
    header('Etag: ' . $etag);
  }

  #$last_modified_time = new DateTime('2014-02-8 08:30:00', new DateTimeZone('UTC'));
  $epoch_secs = get('last_modified', ['default'=>1391848200]);
  if ($epoch_secs!='_') {
    $last_modified_time = new DateTime("@$epoch_secs");
    $time_format = 'D, d M Y H:i:s O';
    $formatted_last_modified_time = $last_modified_time->format($time_format);
    header('Last-Modified: ' . $formatted_last_modified_time);
  }
  return;

}

$name = preg_replace("/[^a-zA-Z0-9.]+/", "", get('name', ['default'=>'freakowild']));
$file = './media/' . $name;
$fp = fopen($file, 'rb');

$type_spec = get('type', ['default'=>'true']);
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

$length_spec = get('length', ['default'=>'true']);
if ($length_spec!='_') {
  if ($length_spec=='true') {
    header("Content-Length: " . filesize($file));
  } else {
    header("Content-Length: " . $length_spec);
  }
}

$pre_delay = limit(0, intval(get('predelay', ['default'=>'0'])), 60);
$post_delay = limit(0, intval(get('postdelay', ['default'=>'0'])), 60);

response_headers();

//print($etag);
//print(server('HTTP_IF_NONE_MATCH'));

sleep($pre_delay);
if ($etag && $etag==server('HTTP_IF_NONE_MATCH')) {
  header('HTTP/1.0 304 Not Modified');
} else if ($formatted_last_modified_time && $formatted_last_modified_time==server('HTTP_IF_MODIFIED_SINCE')) {
  header('HTTP/1.0 304 Not Modified');
} else {
  fpassthru($fp);
}
sleep($post_delay);

fclose($fp);

?>

<?php

function get($param_key, $default=null) {
  return isset($_GET[$param_key]) ? $_GET[$param_key] : $default;
}

function limit($min, $val, $max) {
  return max($min, min($val, $max));
}

$file_id = preg_replace("/[^a-zA-Z0-9]+/", "", get('id', 'freakowild'));
$file = './files/media/' . $file_id . '.mp3';
$fp = fopen($file, 'rb');

$type_spec = get('type', 'true');
if ($type_spec!='false') {
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
if ($length_spec!='false') {
  if ($length_spec=='true') {
    header("Content-Length: " . filesize($file));
  } else {
    header("Content-Length: " . $length_spec);
  }
}

$pre_delay = limit(0, intval(get('predelay', '0')), 60);
$post_delay = limit(0, intval(get('postdelay', '0')), 60);

sleep($pre_delay);
fpassthru($fp);
sleep($post_delay);

?>

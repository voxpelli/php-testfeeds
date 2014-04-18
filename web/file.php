<?php

require_once 'utils.php';

global $file, $name, $need_body, $self_url;

function bodyless_header($header_string, $response_code=null) {
  global $need_body;
  $need_body = false;
  if ($response_code)
    header($header_string, true, $response_code);
  else
    header($header_string);
}

function write_type() {

  global $file;

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

}

function write_length() {

  global $file;

  $length_spec = get('length', ['default'=>'true']);
  if ($length_spec!='_') {
    if ($length_spec=='true') {
      header("Content-Length: " . filesize($file));
    } else {
      header("Content-Length: " . $length_spec);
    }
  }

}

function write_etag() {

  global $name;

  $etag_spec = get('etag', ['default'=>sha1($name)]);
  if ($etag_spec!='_') {
    $etag = '"' . $etag_spec . '"';
    header('Etag: ' . $etag);
  }

  if ($etag && $etag==server('HTTP_IF_NONE_MATCH'))
    bodyless_header('HTTP/1.0 304 Not Modified');

}

function write_last_modified() {

  $epoch_secs = get('last_modified', ['default'=>1391848200]);
  if ($epoch_secs!='_') {
    $last_modified_time = new DateTime("@$epoch_secs");
    $time_format = 'D, d M Y H:i:s O';
    $formatted_last_modified_time = $last_modified_time->format($time_format);
    header('Last-Modified: ' . $formatted_last_modified_time);
  }

  if ($formatted_last_modified_time && $formatted_last_modified_time==server('HTTP_IF_MODIFIED_SINCE'))
    bodyless_header('HTTP/1.0 304 Not Modified', 304);

}

function open_file() {

  global $name, $file;

  $name = preg_replace("/[^a-zA-Z0-9.]+/", "", get('name', ['default'=>'freakowild.mp3']));
  $file = './media/' . $name;
  return fopen($file, 'rb');

}

# Redirect can be a URL or an integer. If it's an integer, it will "count down" 
# by redirecting to the integer minus one, until zero is reached.
# Permanent redirects are handled with the same mechanism, and a check happens at
# the end to output the extra permanent-redirect header
function write_redirect() {

  global $self_url;

  $redirect = get(
    'redirect',[
      'default' => get(
        'permanent_redirect',[
          'default' => get('relative_redirect')
        ]
      )
    ]
  );

  if (strlen($redirect) > 0 && $redirect!='0') {
    $status = 302;
    if (intval($redirect) > 0)
      $redirect_to = preg_replace('/redirect=(\d+)/', 'redirect=' . (intval($redirect)-1), $_SERVER['REQUEST_URI']);
    if (! get('relative_redirect', ['default'=>null]))
      $redirect_to = $self_url . $redirect_to;
    if (get('permanent_redirect')) {
      header("HTTP/1.1 301 Moved Permanently");
      $status = 301;
    }
    bodyless_header('Location: ' . urldecode($redirect_to), $status);
    die();
  }

  return;

}

# prepare
#$url_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$self_url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$self_url .= $_SERVER['HTTP_HOST']; #. $url_parts[0];
$pre_delay = limit(0, intval(get('predelay', ['default'=>'0'])), 60);
$post_delay = limit(0, intval(get('postdelay', ['default'=>'0'])), 60);
sleep($pre_delay);

# Open file and write output
$need_body = true;
$fp = open_file();
write_redirect();
write_type();
write_length();
write_etag();
write_last_modified();
if ($need_body)
  fpassthru($fp);

# Finish
sleep($post_delay);
fclose($fp);

?>

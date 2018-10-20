<?php
// Global config functions
function speedmaster_config($constant, $var) {
  if ( defined($constant) && isset(constant($constant)[$var])) 
    return constant($constant)[$var];
  else
    return false;
}

function speedmaster_get_content($url) {
  global $smconfig;
  
  $local_url = $smconfig->get('optimizer', 'local_url', 'http://127.0.0.1');
  
  if ($local_url !== false) {
    $url = str_replace(site_url(), $local_url, $url);
  }

  $response = wp_remote_get($url); 

  if ( is_array( $response ) ) {
    $header = $response['headers']; // array of http header lines
    $body = $response['body']; // use the content
    return $body;
  }

  if ( is_wp_error( $response ) ) {
    return false;
  }

  return $false;
}

function speedmaster_array_match($matches, $haystack) {
  foreach ($matches as $needle) {
    if (strpos($haystack, $needle) !== false) {
      return true;
    }
  }
  return false;
}

function speedmaster_is_logged_in() {
  $logged_in = false;
  if (count($_COOKIE)) {
    foreach ($_COOKIE as $key => $val) {
      if (preg_match("/wordpress_logged_in/i", $key)) {
       return true;
      }
    }
  }

  return false;
}

function speedmaster_get_cached_files() {
  return glob( SPEEDMASTER_CACHE_DIR."{,.}[!.,!..]*", GLOB_MARK | GLOB_BRACE );
}

function speedmaster_count_cached_files() {
  return count( speedmaster_get_cached_files() );
}

// Buffer functions
function speedmaster_generate_identifier($string = null) {

  if (!$string) {
    $string = $_SERVER['REQUEST_URI'];
  }

  $string = str_replace('/', '-', $string);
  $string = str_replace('?', '-', $string);
  $string = str_replace('=', '_', $string);
  $string = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $string);
  $string = mb_ereg_replace("([\.]{2,})", '', $string);
  $string = trim($string, '-');
  return $string;
}

function speedmaster_save_buffer($identifier, $buffer) {

  if (!isset($buffer) or empty($buffer))
    return;
  
  $buffer = var_export($buffer, true);
  // HHVM fails at __set_state, so just use object cast for now
  $buffer = str_replace('stdClass::__set_state', '(object)', $buffer);
  // Write to temp file first to ensure atomicity
  $tmp = SPEEDMASTER_CACHE_DIR . "$identifier.tmp";
  file_put_contents($tmp, '<?php $buffer = ' . $buffer . ';', LOCK_EX);
  rename($tmp, SPEEDMASTER_CACHE_DIR . "$identifier.cache");
}

function speedmaster_load_buffer($identifier) {
  @include SPEEDMASTER_CACHE_DIR . "$identifier.cache";
  return isset($buffer) ? $buffer : null;
}

function speedmaster_purge_buffer() {
  global $smdb;
  $smdb->increment('cache', 'version_tag');

  try {
    $files = speedmaster_get_cached_files(); // get all file names

    foreach($files as $file){ // iterate files
      unlink($file);
    }

    return true;

  } catch (Exception $e) {

    return false;
  }
  
}


// Admin page functions
function speedmaster_display_status($status) {
  if ($status) {
    return 'Enabled <span class="ab-icon dashicons dashicons-yes"></span>';
  } else {
    return 'Disabled <span class="ab-icon dashicons dashicons-no"></span>';
  }
}

function speedmaster_setting_class( $value ) {
  if ($value === true) {
    return 'enabled';
  } else {
    return 'disabled';
  }
}

function speedmaster_is_writable_icon( $path ) {
  if (file_exists($path) && wp_is_writable($path) === true)
    return '<span style="color:green">ok <span class="dashicons dashicons-yes"></span></span>';

  return '<span style="color:red">failed <span class="dashicons dashicons-no"></span></span>';
}

function speedmaster_constant_is_icon( $constant, $expected ) {

  if (defined($constant) && constant($constant) == $expected)
    return '<span style="color:green">ok <span class="dashicons dashicons-yes"></span></span>';

  return '<span style="color:red">failed <span class="dashicons dashicons-no"></span></span>';
}

function speedmaster_print_url( $url ) {
  if ($url) {
    return $url;
  } else {
    return "<em>None</em>";
  }
}

function speedmaster_print_array( $array ) {
  if (count($array) > 0) {
    return implode(', ', $array);
  } else {
    return "<em>None</em>";
  }
}
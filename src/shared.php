<?php
// Constants that will later be moved to wp-config.php
// define( 'WP_CACHE', true ); // Added by Speedmaster

require_once('shared/paths.php');
require_once('shared/config.php');

function speedmaster_config($constant, $var) {
  if ( defined($constant) && isset(constant($constant)[$var])) 
    return constant($constant)[$var];
  else
    return false;
}

function speedmaster_array_match($matches, $haystack) {
  foreach ($matches as $needle) {
    if (strpos($haystack, $needle) !== false) {
      return true;
    }
  }
  return false;
}

function speedmaster_generate_identifier() {
  $string = $_SERVER['REQUEST_URI'];
  $string = str_replace('/', '-', $string);
  $string = str_replace('?', '-', $string);
  $string = str_replace('=', '_', $string);
  $string = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $string);
  $string = mb_ereg_replace("([\.]{2,})", '', $string);
  $string = trim($string, '-');
  return $string;
}

function speedmaster_save_buffer($identifier, $buffer) {
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
  if (!defined('SPEEDMASTER_CACHE') )
    return;

  try {
    $files = glob(SPEEDMASTER_CACHE_DIR."*.cache"); // get all file names
    foreach($files as $file){ // iterate files
      unlink($file);
    }

    return true;
  } catch (Exception $e) {
    return false;
  }
  
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
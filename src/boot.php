<?php
/*
 * BOOT file
 * Code in this file will be loaded before Wordpress CORE and databases are loaded.
*/

// Load shared functions
require_once('shared.php');

function is_excluded_request() {
  foreach(SPEEDMASTER_CACHE_CONFIG['exclude'] as $exclude) {
    if (strpos($_SERVER['REQUEST_URI'], $exclude) !== false) {
      return true;
    }
  }
  return false;
}

$identifier = speedmaster_generate_identifier();

if (strpos($identifier, '.sm.css') !== false) {
  $content = speedmaster_load_buffer($identifier);
  header("Content-type: text/css");
  echo $content;
  exit();
}

if (strpos($identifier, '.sm.js') !== false) {
  $content = speedmaster_load_buffer($identifier);
  header("Content-type: text/javascript");
  echo $content;
  exit();
}

if (defined('SPEEDMASTER_CACHE') && SPEEDMASTER_CACHE == true) {
  if ($cached_buffer = speedmaster_load_buffer($identifier)) {    
    if (speedmaster_is_logged_in() === false && is_excluded_request() === false) {
      echo $cached_buffer;
      exit();
    }
  }
}


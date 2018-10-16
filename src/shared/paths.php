<?php
if (!defined('SPEEDMASTER_DATA_DIR'))
  define( 'SPEEDMASTER_DATA_DIR', ABSPATH . 'wp-content/uploads/speedmaster/');

if (!defined('SPEEDMASTER_CACHE_DIR'))
  define( 'SPEEDMASTER_CACHE_DIR', SPEEDMASTER_DATA_DIR . 'cache/'); 

if (!defined('SPEEDMASTER_CONFIG_FILE'))
  define( 'SPEEDMASTER_CONFIG_FILE', SPEEDMASTER_DATA_DIR . 'speedmaster.json');

if (!defined('SPEEDMASTER_PLUGIN_DIR'))
  define( 'SPEEDMASTER_PLUGIN_DIR', ABSPATH . 'wp-content/plugins/speedmaster/');

define( 'SPEEDMASTER_INC_DIR', SPEEDMASTER_PLUGIN_DIR . 'inc/' );
define( 'SPEEDMASTER_FUNC_DIR', SPEEDMASTER_PLUGIN_DIR . 'func/' );
define( 'SPEEDMASTER_ADMIN_DIR', SPEEDMASTER_PLUGIN_DIR . 'admin/' );
define( 'SPEEDMASTER_LIB_DIR', SPEEDMASTER_PLUGIN_DIR . 'lib/' );

// Create directories if they do not exists.
if (!file_exists(SPEEDMASTER_DATA_DIR)) { mkdir(SPEEDMASTER_DATA_DIR, 0777, true); }
if (!file_exists(SPEEDMASTER_CACHE_DIR)) { mkdir(SPEEDMASTER_CACHE_DIR, 0777, true); }
if (!file_exists(SPEEDMASTER_CONFIG_FILE)) { touch(SPEEDMASTER_CONFIG_FILE, 0777, true); }
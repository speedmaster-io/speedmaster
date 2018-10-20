<?php
// Path to wp-config.php
if (!defined('SPEEDMASTER_WP_CONFIG_FILE'))
  define( 'SPEEDMASTER_WP_CONFIG_FILE', ABSPATH . 'wp-config.php' );

// WP-content directory. Used for generating other paths.
if (!defined('SPEEDMASTER_WP_CONTENT_DIR'))
  define( 'SPEEDMASTER_WP_CONTENT_DIR', ABSPATH . 'wp-content/');

if (!defined('SPEEDMASTER_DATA_DIR'))
  define( 'SPEEDMASTER_DATA_DIR', SPEEDMASTER_WP_CONTENT_DIR . 'uploads/speedmaster/');

if (!defined('SPEEDMASTER_ADVANCED_CACHE_FILE'))
  define( 'SPEEDMASTER_ADVANCED_CACHE_FILE', SPEEDMASTER_WP_CONTENT_DIR . 'advanced-cache.php' );


// Data directory. Used to store speedmaster related files.
if (!defined('SPEEDMASTER_CACHE_DIR'))
  define( 'SPEEDMASTER_CACHE_DIR', SPEEDMASTER_DATA_DIR . 'cache/'); 

if (!defined('SPEEDMASTER_CONFIG_FILE'))
  define( 'SPEEDMASTER_CONFIG_FILE', SPEEDMASTER_DATA_DIR . 'speedmaster.json');

if (!defined('SPEEDMASTER_STORAGE_FILE'))
  define( 'SPEEDMASTER_STORAGE_FILE', SPEEDMASTER_DATA_DIR . '.db.json');

// Plugin directory paths
if (!defined('SPEEDMASTER_PLUGIN_DIR'))
  define( 'SPEEDMASTER_PLUGIN_DIR', SPEEDMASTER_WP_CONTENT_DIR . 'plugins/speedmaster/');

if (!defined('SPEEDMASTER_INC_DIR'))
  define( 'SPEEDMASTER_INC_DIR', SPEEDMASTER_PLUGIN_DIR . 'inc/' );

if (!defined('SPEEDMASTER_FUNC_DIR'))
  define( 'SPEEDMASTER_FUNC_DIR', SPEEDMASTER_PLUGIN_DIR . 'func/' );

if (!defined('SPEEDMASTER_MODULES_DIR'))
  define( 'SPEEDMASTER_MODULES_DIR', SPEEDMASTER_PLUGIN_DIR . 'modules/' );


if (!defined('SPEEDMASTER_ADMIN_DIR'))
  define( 'SPEEDMASTER_ADMIN_DIR', SPEEDMASTER_PLUGIN_DIR . 'admin/' );

if (!defined('SPEEDMASTER_LIB_DIR'))
  define( 'SPEEDMASTER_LIB_DIR', SPEEDMASTER_PLUGIN_DIR . 'lib/' );
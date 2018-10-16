<?php
if (!defined('SPEEDMASTER_DATA_DIR'))
  define( 'SPEEDMASTER_DATA_DIR', ABSPATH . 'wp-content/uploads/speedmaster/');

if (!defined('SPEEDMASTER_WP_CONTENT_DIR'))
  define( 'SPEEDMASTER_WP_CONTENT_DIR', ABSPATH . 'wp-content/');

if (!defined('SPEEDMASTER_CACHE_DIR'))
  define( 'SPEEDMASTER_CACHE_DIR', SPEEDMASTER_DATA_DIR . 'cache/'); 

if (!defined('SPEEDMASTER_ADVANCED_CACHE_FILE'))
  define( 'SPEEDMASTER_ADVANCED_CACHE_FILE', SPEEDMASTER_WP_CONTENT_DIR . 'advanced-cache.php' );

if (!defined('SPEEDMASTER_WP_CONFIG_FILE'))
  define( 'SPEEDMASTER_WP_CONFIG_FILE', ABSPATH . 'wp-config.php' );

if (!defined('SPEEDMASTER_CONFIG_FILE'))
  define( 'SPEEDMASTER_CONFIG_FILE', SPEEDMASTER_DATA_DIR . 'speedmaster.json');

if (!defined('SPEEDMASTER_PLUGIN_DIR'))
  define( 'SPEEDMASTER_PLUGIN_DIR', SPEEDMASTER_WP_CONTENT_DIR . 'plugins/speedmaster/');

define( 'SPEEDMASTER_INC_DIR', SPEEDMASTER_PLUGIN_DIR . 'inc/' );
define( 'SPEEDMASTER_FUNC_DIR', SPEEDMASTER_PLUGIN_DIR . 'func/' );
define( 'SPEEDMASTER_ADMIN_DIR', SPEEDMASTER_PLUGIN_DIR . 'admin/' );
define( 'SPEEDMASTER_LIB_DIR', SPEEDMASTER_PLUGIN_DIR . 'lib/' );
<?php
/* MySQL settings */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME'));
define( 'DB_USER', getenv('WORDPRESS_DB_USER'));
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD'));
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST'));
define( 'DB_CHARSET',  'utf8' );

define( 'AUTH_KEY',         'secret' );
define( 'SECURE_AUTH_KEY',  'secret' );
define( 'LOGGED_IN_KEY',    'secret' );
define( 'NONCE_KEY',        'secret' );
define( 'AUTH_SALT',        'secret' );
define( 'SECURE_AUTH_SALT', 'secret' );
define( 'LOGGED_IN_SALT',   'secret' );
define( 'NONCE_SALT',       'secret' );

$table_prefix  = 'wp_';

// Turns WordPress debugging on
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);

if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
  $_SERVER['HTTPS']='on';

/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
<?php
/*
Plugin Name: Speedmaster
Plugin URI: https://speedmaster.io
Description: File system cache, CSS, JS and HTML minification, CDN and much more.
Author: Rasmus Kjellberg
Author URI: https://speedmaster.io
Version: 1.0.0
Text Domain: speedmaster
*/

define( 'SPEEDMASTER_VERSION', '0.0.1' );

// Load shared functions
require_once('shared.php');

// Buffer HTML that we can filter
if (!defined('SPEEDMASTER_DISABLED')) { 

  require_once( SPEEDMASTER_INC_DIR . 'buffer.php' ); 

  if (is_admin()) {
    // Load admin panels and actions
    require_once( SPEEDMASTER_ADMIN_DIR . 'settings-page.php' );
    require_once( SPEEDMASTER_ADMIN_DIR . 'toolbar.php' );
    require_once( SPEEDMASTER_ADMIN_DIR . '_delete-cache.php' );

  } else {
    // Load front-end generators (functions)
    if (defined('SPEEDMASTER_OPTIMIZER') && SPEEDMASTER_OPTIMIZER == true ) { 
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/Minify.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/CSS.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/JS.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/Exception.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/Exceptions/BasicException.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/Exceptions/FileImportException.php';
      require_once SPEEDMASTER_LIB_DIR . 'minify/src/Exceptions/IOException.php';
      require_once SPEEDMASTER_LIB_DIR . 'path-converter/src/ConverterInterface.php';
      require_once SPEEDMASTER_LIB_DIR . 'path-converter/src/Converter.php';

      require_once SPEEDMASTER_LIB_DIR . 'minify-html.php';

      require_once SPEEDMASTER_FUNC_DIR . 'optimizer.php'; 
    }

    if (defined('SPEEDMASTER_LAZYLOAD') && SPEEDMASTER_LAZYLOAD == true ) { require_once( SPEEDMASTER_FUNC_DIR . 'lazyload.php' ); }
    if (defined('SPEEDMASTER_CDN') && SPEEDMASTER_CDN == true ) { require_once( SPEEDMASTER_FUNC_DIR . 'cdn.php' ); }

  }

}

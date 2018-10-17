<?php
/*
Plugin Name: Speedmaster
Description: File system cache, CSS, JS, HTML combine & minify, CDN and much more.
Author: Speedmaster.io
Author URI: https://speedmaster.io
Version: 0.0.1
Text Domain: speedmaster
*/

// Load shared functions
require_once('shared.php');

register_activation_hook( __FILE__, 'speedmaster_activation_hook' );
function speedmaster_activation_hook() {
  // Load installer class
  require_once('installer.php');

  $installer = new SpeedMasterInstaller;
  $installer->run();
}

register_deactivation_hook( __FILE__, 'speedmaster_deactivation_hook' );
function speedmaster_deactivation_hook() {
  // Load installer class
  require_once('installer.php');

  $installer = new SpeedMasterInstaller;
  $installer->uninstall();
}

// Buffer HTML that we can filter
if (!defined('SPEEDMASTER_DISABLED')) { 

  require_once( SPEEDMASTER_INC_DIR . 'buffer.php' ); 

  if (speedmaster_is_logged_in() === true) {
    // Load admin panels and actions
    require_once( SPEEDMASTER_ADMIN_DIR . 'settings-page.php' );
    require_once( SPEEDMASTER_ADMIN_DIR . 'toolbar.php' );

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

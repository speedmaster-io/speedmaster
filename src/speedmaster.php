<?php
/*
Plugin Name: Speedmaster
Description: File system cache, CSS, JS, HTML combine & minify, CDN and much more.
Author: Speedmaster.io
Author URI: https://speedmaster.io
Version: 0.0.1
Text Domain: speedmaster
*/

// First check if the SPEEDMASTER_DISABLED is set. If it is, we shouldn't do anything.
if (!defined('SPEEDMASTER_DISABLED')) {

  // Load shared classes and modules.
  require_once('shared.php');

  // Activation scripts
  register_activation_hook( __FILE__, 'speedmaster_activation_hook' );
  function speedmaster_activation_hook() {
    // Load installer class
    require_once('installer.php');

    // Install and create datadirs and config files.
    $installer = new SpeedMasterInstaller;
    $installer->run();
  }

  // Deactivation scripts
  register_deactivation_hook( __FILE__, 'speedmaster_deactivation_hook' );
  function speedmaster_deactivation_hook() {
    // Load installer class
    require_once('installer.php');

    // Uninstall and remove plugin files.
    $installer = new SpeedMasterInstaller;
    $installer->uninstall();
  }

  // Buffer HTML that we can filter
  require_once( SPEEDMASTER_INC_DIR . 'buffer.php' );

  if (speedmaster_is_logged_in() === true) {
    // Load admin panels and actions
    require_once( SPEEDMASTER_ADMIN_DIR . 'settings-page.php' );
    require_once( SPEEDMASTER_ADMIN_DIR . 'toolbar.php' );

  } else {
    // Load third-party libraries and classes.
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

    // Load front-end generators (functions)
    // @todo: Only load these scripts if optimizer:enabled is set to true.
    // require_once SPEEDMASTER_FUNC_DIR . 'cdn.php';

    if ($smconfig->get('optimizer', 'enabled')) {
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/disable-emojis.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/disable-embed.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/minify-html.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/minify-css.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/minify-js.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/remove-version-numbers.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/combine.php';
      require_once SPEEDMASTER_MODULES_DIR . 'optimizer/footer-scripts.php';
    }

    if ($smconfig->get('cdn', 'enabled')) {
    	require_once SPEEDMASTER_MODULES_DIR . 'cdn.php';
    }

  }

}

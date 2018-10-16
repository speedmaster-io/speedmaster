<?php
class SpeedMasterInstaller {
  public function run() {
    // Create directories if they do not exists.
    if (!file_exists(SPEEDMASTER_DATA_DIR)) { mkdir(SPEEDMASTER_DATA_DIR, 0777, true); }
    if (!file_exists(SPEEDMASTER_CACHE_DIR)) { mkdir(SPEEDMASTER_CACHE_DIR, 0777, true); }

    $this->create_speedmaster_files();
    $this->enableCacheInWpConfig();
  }

  function create_speedmaster_files() {
    if (file_exists(SPEEDMASTER_CONFIG_FILE) === false) {
      $this->recreate_speedmaster_json();
    }

    $this->recreate_advanced_cache_file();
  }

  private function recreate_speedmaster_json() {
    @touch(SPEEDMASTER_CONFIG_FILE, 0777, true);
    file_put_contents(SPEEDMASTER_CONFIG_FILE, '{
  "cache": {
    "enabled": true,
    "exclude": []
  },
  "optimizer": {
    "enabled": true,
    "combine_css": true,
    "minify_css": true,
    "exclude_css": [],

    "combine_js": true,
    "minify_js": true,
    "footer_js": false,
    "exclude_js": [],

    "minify_html": false,
    "disable_embed": true
  },
  "cdn": {
    "enabled": false,
    "hosts": ["'.site_url().'"],
    "url": "http://cdn.mywebsite.com/",
    "include": [],
    "exclude": []
  }
}');
  }

  private function recreate_advanced_cache_file() {
    @touch(SPEEDMASTER_ADVANCED_CACHE_FILE, 0777, true);
    file_put_contents(SPEEDMASTER_ADVANCED_CACHE_FILE, "<?php
// Created by Speedmaster
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );
define( 'SPEEDMASTER_ACTIVATED', true );
require_once( '".SPEEDMASTER_PLUGIN_DIR."/boot.php');");
  }

  function enableCacheInWpConfig() {
    // Update config file
    if (file_exists(SPEEDMASTER_WP_CONFIG_FILE)) {
      require_once(SPEEDMASTER_LIB_DIR . 'wp-config-transformer.php');
      $config = new WPConfigTransformer( SPEEDMASTER_WP_CONFIG_FILE );
      $config->update( 'constant', 'WP_CACHE', 'true', array( 
        'raw' => true, 
        'normalize' => true, 
        'anchor' => '<?php', 
        'placement' => 'after', 
        'separator' => PHP_EOL, 
        'add' => true ) 
      );
    }
  }
}

$installer = new SpeedMasterInstaller;
$installer->run();
<?php
class SpeedMasterInstaller {
  public function run() {
    $this->recreate_data_dir();
    $this->recreate_cache_dir();

    $this->recreate_config_file();
    $this->recreate_storage_file();
    $this->recreate_advanced_cache_file();
    $this->update_wpconfig_var_to('true');
  }

  public function uninstall() {
    $this->update_wpconfig_var_to('false');

    speedmaster_purge_buffer();
    unlink(SPEEDMASTER_ADVANCED_CACHE_FILE);
  }

  private function recreate_data_dir() {
    if (file_exists(SPEEDMASTER_DATA_DIR))
      return;
    
    mkdir(SPEEDMASTER_DATA_DIR, 0777, true);
  }

  private function recreate_cache_dir() {
    if (file_exists(SPEEDMASTER_CACHE_DIR))
      return;
    
    mkdir(SPEEDMASTER_CACHE_DIR, 0777, true);
  }

  private function recreate_config_file() {
    if (file_exists(SPEEDMASTER_CONFIG_FILE))
      return;

    @touch(SPEEDMASTER_CONFIG_FILE, 0777, true);
    file_put_contents(SPEEDMASTER_CONFIG_FILE, '{
  "cache": {
    "enabled": false,
    "exclude": []
  },
  "optimizer": {
    "enabled": true,

    "minify_html": false,
    "remove_ver": true,
    "local_url": "http://127.0.0.1",
    "disable_emojis": true,
    "disable_embed": true,

    "minify_css": true,
    "combine_css": false,
    "exclude_css": ["bootstrap", "font-awesome"],

    "minify_js": true,
    "combine_js": false,
    "exclude_js": [],
    "js_in_footer": false
  },
  "cdn": {
    "enabled": false,
    "hosts": ["http://localhost:8080"],
    "url": "http://cdn.mywebsite.com/",
    "include": [],
    "exclude": []
  }
}');
  }

  private function recreate_storage_file() {
    if (file_exists(SPEEDMASTER_STORAGE_FILE))
      return;

    @touch(SPEEDMASTER_STORAGE_FILE, 0777, true);
    file_put_contents(SPEEDMASTER_STORAGE_FILE, '{
  "cache": {
    "version_tag": 0
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

  function update_wpconfig_var_to($value = 'true') {
    // Update config file
    if (file_exists(SPEEDMASTER_WP_CONFIG_FILE)) {
      require_once(SPEEDMASTER_LIB_DIR . 'wp-config-transformer.php');
      $config = new WPConfigTransformer( SPEEDMASTER_WP_CONFIG_FILE );
      $config->update( 'constant', 'WP_CACHE', $value, array( 
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
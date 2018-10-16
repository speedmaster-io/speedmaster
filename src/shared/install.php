<?php
class SpeedMasterInstaller {
  public function run() {
    // Create directories if they do not exists.
    if (!file_exists(SPEEDMASTER_DATA_DIR)) { mkdir(SPEEDMASTER_DATA_DIR, 0777, true); }
    if (!file_exists(SPEEDMASTER_CACHE_DIR)) { mkdir(SPEEDMASTER_CACHE_DIR, 0777, true); }
    if (!file_exists(SPEEDMASTER_ADVANCED_CACHE_FILE)) { touch(SPEEDMASTER_ADVANCED_CACHE_FILE, 0777, true); }

    $this->updateSpeedmasterConfig();
    $this->updateConfigFile();
  }

  function updateSpeedmasterConfig() {
    if (file_exists(SPEEDMASTER_CONFIG_FILE) === false) {
      $this->reCreateConfig();
    }
  }

  private function reCreateConfig() {
    $json = speedmaster_default_config_json();
    @touch(SPEEDMASTER_CONFIG_FILE, 0777, true);
    file_put_contents(SPEEDMASTER_CONFIG_FILE, $json);
  }

  function updateConfigFile() {
    // Update config file
    if (file_exists(SPEEDMASTER_WP_CONFIG_FILE)) {
      require_once(SPEEDMASTER_LIB_DIR . 'wp-config-transformer.php');
      $config = new WPConfigTransformer( SPEEDMASTER_WP_CONFIG_FILE );
      $config->update( 'constant', 'WP_CACHE', 'true', array( 
        'raw' => true, 
        'normalize' => true, 
        'anchor' => '<?php', 
        'placement' => 'before', 
        'separator' => PHP_EOL . PHP_EOL, 
        'add' => true ) 
      );
    }
  }
}

$installer = new SpeedMasterInstaller;
$installer->run();
<?php
class SpeedmasterConfigLoader {
  function __construct() {
    $this->config = [];
    $this->loadConfigFile();
  }

  public function get($primary_key, $secondary_key = null, $default = false) {
    if (isset($this->config[$primary_key][$secondary_key])) {
      return $this->config[$primary_key][$secondary_key];
    } else if (isset($this->config[$primary_key]) && !isset($secondary_key)) {
      return $this->config[$primary_key];
    } else {
      return $default;
    }
  }

  function loadConfigFile() {
    if ($file_contents = @file_get_contents(SPEEDMASTER_CONFIG_FILE)) {
      $this->config = json_decode($file_contents, true);
    } else {
      $this->config = [];
    }
  }
}

$config = new SpeedmasterConfigLoader();

define( 'SPEEDMASTER_CACHE_CONFIG', [
  'enabled' => $config->get('cache', 'enabled', false),
  'exclude' => $config->get('cache', 'exclude', []),
]);

define( 'SPEEDMASTER_OPTIMIZER_CONFIG', [
  'enabled' => $config->get('optimizer', 'enabled', false),

  'combine_css' => $config->get('optimizer', 'combine_css', false),
  'minify_css' => $config->get('optimizer', 'minify_css', false),
  'exclude_css' => $config->get('optimizer', 'exclude_css', []),

  'combine_js' => $config->get('optimizer', 'combine_js', false),
  'minify_js' => $config->get('optimizer', 'minify_js', false),
  'exclude_js' => $config->get('optimizer', 'exclude_js', []),
  'footer_js' => $config->get('optimizer', 'footer_js', false),

  'minify_html' => $config->get('optimizer', 'minify_html', false),
  
  'disable_embed' => $config->get('optimizer', 'disable_embed', false),

  'local_url' => 'http://127.0.0.1',
]);

define( 'SPEEDMASTER_CDN_CONFIG', [
  'enabled' => $config->get('cdn', 'enabled', false),
  'hosts' => $config->get('cdn', 'hosts', []),
  'include' => $config->get('cdn', 'include', []),
  'exclude' => $config->get('cdn', 'exclude', []),
  'cdn_url' => $config->get('cdn', 'url', null)
]);


define( 'SPEEDMASTER_CACHE', SPEEDMASTER_CACHE_CONFIG['enabled']);
define( 'SPEEDMASTER_OPTIMIZER', SPEEDMASTER_OPTIMIZER_CONFIG['enabled']);
define( 'SPEEDMASTER_CDN', SPEEDMASTER_CDN_CONFIG['enabled']);
define( 'SPEEDMASTER_LAZYLOAD', true);
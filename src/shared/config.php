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

global $smconfig;
$smconfig = new SpeedmasterConfigLoader();

define( 'SPEEDMASTER_CACHE_CONFIG', [
	'enabled' => $smconfig->get('cache', 'enabled', false),
	'exclude' => $smconfig->get('cache', 'exclude', []),
]);

define( 'SPEEDMASTER_OPTIMIZER_CONFIG', [
	'enabled' => $smconfig->get('optimizer', 'enabled', false),

	'combine_css' => $smconfig->get('optimizer', 'combine_css', false),
	'minify_css' => $smconfig->get('optimizer', 'minify_css', false),
	'exclude_css' => $smconfig->get('optimizer', 'exclude_css', []),

	'combine_js' => $smconfig->get('optimizer', 'combine_js', false),
	'minify_js' => $smconfig->get('optimizer', 'minify_js', false),
	'exclude_js' => $smconfig->get('optimizer', 'exclude_js', []),
	'footer_js' => $smconfig->get('optimizer', 'footer_js', false),

	'minify_html' => $smconfig->get('optimizer', 'minify_html', false),

	'disable_embed' => $smconfig->get('optimizer', 'disable_embed', false),

	'local_url' => 'http://127.0.0.1',
]);

define( 'SPEEDMASTER_CDN_CONFIG', [
	'enabled' => $smconfig->get('cdn', 'enabled', false),
	'hosts' => $smconfig->get('cdn', 'hosts', []),
	'include' => $smconfig->get('cdn', 'include', []),
	'exclude' => $smconfig->get('cdn', 'exclude', []),
	'cdn_url' => $smconfig->get('cdn', 'url', null)
]);


define( 'SPEEDMASTER_CACHE', SPEEDMASTER_CACHE_CONFIG['enabled']);
define( 'SPEEDMASTER_OPTIMIZER', SPEEDMASTER_OPTIMIZER_CONFIG['enabled']);
define( 'SPEEDMASTER_CDN', SPEEDMASTER_CDN_CONFIG['enabled']);
define( 'SPEEDMASTER_LAZYLOAD', true);

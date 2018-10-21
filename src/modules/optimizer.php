<?php
// Check Speedmaster configuration
if ($smconfig->get('optimizer', 'enabled')) {
  add_filter('speedmaster_buffer', 'speedmaster_init_optimizer');
}

/*
 * Speedmaster Optimizer
 *
 * This function will buffer all css and JS files and cache them so that other modules can manipulate them.
*/
function speedmaster_init_optimizer($buffer) {
  $optimizer = new SpeedmasterOptimizer($buffer);

  // Optimizer functions
  $stylesheets = $optimizer->load_css();
  $javascripts = $optimizer->load_js();

  $files = array_merge($stylesheets, $javascripts);

  foreach ($files as $file) {
    $buffer = str_replace($file['original'], $file['cached'], $buffer);
  }

  return $buffer;
}

class SpeedmasterOptimizer
{

  function __construct($html) {
    $this->html = $html;
  }

  public function load_css() {
    global $smdb;
    $version_tag = $smdb->get('cache', 'version_tag', '0');

    $output_urls = [];
    $urls = $this->load_urls_from_html('link', 'href', '.css');
    foreach ($urls as $url) {
      if ($url['external'])
        continue;

      $new_url = str_replace(site_url(), '', $url['original']);
      $new_url = str_replace('.css', "-{$version_tag}.sm.css", $new_url);
      $identifier = speedmaster_generate_identifier($new_url);

      if (!speedmaster_load_buffer($identifier)) {
        // Download content
        $content = speedmaster_get_content($url['path']);
        speedmaster_save_buffer($identifier, apply_filters('speedmaster_css', $content));
      }

      $url['cached'] = $new_url;
      $url['element_replace'] = str_replace($url['original'], $new_url, $url['element']);
      $output_urls[] = $url;
    }

    return $output_urls;
  }

  public function load_js() {
    global $smdb;
    $version_tag = $smdb->get('cache', 'version_tag', '0');

    $output_urls = [];
    $urls = $this->load_urls_from_html('script', 'src', '.js');
    foreach ($urls as $url) {
      if ($url['external'])
        continue;

      $new_url = str_replace(site_url(), '', $url['original']);
      $new_url = str_replace('.js', "-{$version_tag}.sm.js", $new_url);
      $identifier = speedmaster_generate_identifier($new_url);

      if (!speedmaster_load_buffer($identifier)) {
        // Download content
        $content = speedmaster_get_content($url['path']);
        speedmaster_save_buffer($identifier, apply_filters('speedmaster_js', $content));
      }

      $url['cached'] = $new_url;
      $url['element_replace'] = str_replace($url['original'], $new_url, $url['element']);
      $output_urls[] = $url;
    }

    return $output_urls;
  }

  function load_urls_from_html($tag = 'link', $attr = 'href', $ext = '.css') {
    $urls = [];

    $dom = new DOMDocument;
    @$dom->loadHTML($this->html);

    $elements = $dom->getElementsByTagName($tag);
    foreach ($elements as $element) {
      $full_url = $element->getAttribute($attr);
      $full_element = $dom->saveHtml($element);
      $parts = explode("?", $full_url);
      $url = $parts[0];

      if (! $this->ends_with($url, $ext) )
        continue;

      $urls[] = $this->parse_url($full_url, $full_element);
    }

    return $urls;
  }

  function parse_url($url, $element)
  {
    $original = $url;
    $local_path = false;
    $external = false;

    // Check if url is relative but not //
    if ($url[0] == "/" && $url[1] != "/") {
      $url = site_url() . $url;
    }

    else if (strpos($url, site_url()) !== false) {
      $url = $url;
    }

    else {
      $url = $url;
      $external = true;
    }

    $local_path = $this->replace_url_with_src($url);

    return [
      'original' => $original,
      'path' => $url,
      'external' => $external,
      'element' => $element
    ];
  }

  function replace_url_with_src($url) {

    $url = explode('?', $url);
    $url = $url[0];

    $url = str_replace(get_template_directory_uri(), get_template_directory(), $url);
    $url = str_replace(site_url(), ABSPATH, $url);

    return $url;
  }

  // Check if the url ends with
  function ends_with($haystack, $needle)
  {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
  }
}

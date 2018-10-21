<?php
add_action( 'wp_enqueue_scripts', 'speedmaster_combine', PHP_INT_MAX );

/*
 * Combine CSS & JS
 * Speedmaster Optimizer
 *
 * Combine enqueued scripts and stylesheets to one.
*/
function speedmaster_combine() {
  global $smconfig;

  if ($smconfig->get('optimizer', 'combine_css')) {
    combine_css();
  }

  if ($smconfig->get('optimizer', 'combine_js')) {
    combine_js();
  }
}

function remove_ver_from_combined( $src ) {
  if ( strpos( $src, 'style.css' ) )
    $src = remove_query_arg( 'ver', $src );

  return $src;
}

function combine_css() {
  global $wp_styles;
  global $smconfig;

  add_filter( 'style_loader_src', 'remove_ver_from_combined', 9999 );

  $exclude = $smconfig->get('optimizer', 'exclude_css', []);
  $exclude = array_merge($exclude, ['admin']);

  $new_url = str_replace(site_url(), '', get_template_directory_uri() . "/combined.style.sm.css");
  $identifier = speedmaster_generate_identifier($new_url);

  $content = null;
  if ($smconfig->get('cache', 'enabled'))
    $content = speedmaster_load_buffer($identifier);

  if (!$content) {
    foreach( $wp_styles->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle))
        continue;

      $url = $wp_styles->registered[$handle]->src;

      // Check if url is relative but not //
      if ($url[0] == "/" && $url[1] != "/") {
        $url = site_url() . $url;
      }

      $new_content = speedmaster_get_content($url);

      $file_name = explode('/', $url);
      $file_name = $file_name[count($file_name) - 1];

      $url_path = str_replace($file_name, '', $url);

      $new_content = str_replace('../', $url_path . '../', $new_content);

      $content .= $new_content . "\n";
    }

    $content = apply_filters('speedmaster_combined_css', $content);

    speedmaster_save_buffer($identifier, $content);
  }

  if ($content) {
    foreach( $wp_styles->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle))
        continue;

      wp_dequeue_style($handle);
    }

    wp_enqueue_style('speedmaster', $new_url);
  }
}

function combine_js() {
  global $wp_scripts;
  global $smconfig;

  add_filter( 'script_loader_src', 'remove_ver_from_combined', 9999 );

  $exclude = $smconfig->get('optimizer', 'exclude_js', []);
  $exclude = array_merge($exclude, ['admin']);

  $new_url = str_replace(site_url(), '', get_template_directory_uri() . "/combined.script.sm.js");
  $identifier = speedmaster_generate_identifier($new_url);

  $content = null;
  if ($smconfig->get('cache', 'enabled'))
    $content = speedmaster_load_buffer($identifier);

  if (!$content) {
    foreach( $wp_scripts->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle))
        continue;

      $url = $wp_scripts->registered[$handle]->src;

      // Check if url is relative but not //
      if ($url[0] == "/" && $url[1] != "/") {
        $url = site_url() . $url;
      }

      $new_content = speedmaster_get_content($url);

      $file_name = explode('/', $url);
      $file_name = $file_name[count($file_name) - 1];

      $url_path = str_replace($file_name, '', $url);

      $new_content = str_replace('../', $url_path . '../', $new_content);

      $content .= $new_content . "\n";
    }

    // Add jQuery
    $jquery_content = speedmaster_get_content(includes_url( '/js/jquery/jquery.js' ));
    $content = $jquery_content . "\n" . $content;

    $content = apply_filters('speedmaster_combined_css', $content);

    speedmaster_save_buffer($identifier, $content);
  }

  if ($content) {
    foreach( $wp_scripts->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle))
        continue;

      wp_dequeue_script($handle);
    }

    $js_in_footer = $smconfig->get('optimizer', 'js_in_footer', false);
    wp_enqueue_script('speedmaster', $new_url, false, false, false);

  }
}


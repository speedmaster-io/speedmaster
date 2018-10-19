<?php
function remove_ver_from_combined( $src ) {
  if ( strpos( $src, 'style.css' ) )
      $src = remove_query_arg( 'ver', $src );
  return $src;
}

function combine_css() {
  global $wp_styles;

  add_filter( 'style_loader_src', 'remove_ver_from_combined', 9999 );
  add_filter( 'script_loader_src', 'remove_ver_from_combined', 9999 );

  $exclude = SPEEDMASTER_OPTIMIZER_CONFIG['exclude_css'];
  $exclude = array_merge($exclude, ['admin']);

  $identifier = substr(md5(implode('-', $wp_styles->queue)), 0, 10) . ".style.css";
  
  $content = null;
  if (SPEEDMASTER_CACHE_CONFIG['enabled'] == true)
    $content = speedmaster_load_buffer($identifier);

  if (!$content) { 
    foreach( $wp_styles->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle)) 
        continue;

      $url = $wp_styles->registered[$handle]->src;
      $content .= speedmaster_get_content($url) . "\n";
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

    wp_enqueue_style('speedmaster', "/{$identifier}");
  }
}

function combine_js() {
  global $wp_scripts;

  $exclude = SPEEDMASTER_OPTIMIZER_CONFIG['exclude_js'];
  $exclude = array_merge($exclude, ['admin']);

  $identifier = substr(md5(implode('-', $wp_scripts->queue)), 0, 10) . ".script.js";

  $content = speedmaster_load_buffer($identifier);

  if (!$content) { 
    foreach( $wp_scripts->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle)) 
        continue;

      $url = $wp_scripts->registered[$handle]->src;
      $content .= speedmaster_get_content($url);
    }

    $content = apply_filters('speedmaster_combined_js', $content);
    speedmaster_save_buffer($identifier, $content);
  }

  if ($content) {
    foreach( $wp_scripts->queue as $handle ) {
      if (speedmaster_array_match($exclude, $handle))
        continue;

      wp_dequeue_script($handle);
    }

    wp_enqueue_script('speedmaster', "/{$identifier}", array('jquery'), false, speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'footer_js'));
  }
}

function speedmaster_get_content($url) {
  $local_url = speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'local_url');
  if ($local_url !== false) {
    $url = str_replace(site_url(), $local_url, $url);
  }

  $response = wp_remote_get($url); 

  if ( is_array( $response ) ) {
    $header = $response['headers']; // array of http header lines
    $body = $response['body']; // use the content
    return $body;
  }

  if ( is_wp_error( $response ) ) {
    return false;
  }

  return $false;
}

function speedmaster_combine_css_and_js() {
  if ( speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'combine_css') ) {
    combine_css();
  }

  if ( speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'combine_js') ) {
    combine_js();
  }
}


function speedmaster_minify_css_and_js() {

  if ( speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'minify_css') ) {
    add_filter('speedmaster_combined_css', function($css) {
      $minifier = new Minify\CSS($css);
      return $minifier->minify();
    });
  }

  if ( speedmaster_config('SPEEDMASTER_OPTIMIZER_CONFIG', 'minify_js') ) {
    add_filter('speedmaster_combined_js', function($js) {
      $minifier = new Minify\JS($js);
      return $minifier->minify();
    });
  }
}

add_action( 'wp_enqueue_scripts', 'speedmaster_combine_css_and_js', PHP_INT_MAX );
add_action( 'init', 'speedmaster_minify_css_and_js', PHP_INT_MAX );
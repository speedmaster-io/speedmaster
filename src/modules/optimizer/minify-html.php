<?php
use MatthiasMullie\Minify;

/*
 * Minify HTML
 * Speedmaster Optimizer
 * 
 * This function will minify all your outputed HTML by removing white-spaces, comments etc.
*/
function speedmaster_minify_html($html) {
  global $smconfig;

  if ($smconfig->get('optimizer', 'minify_html')) {
    // Return minified HTML if set to true
    return minify_html($html);
  } else {
    // Else return normal HTML
    return $html;
  }
}

add_filter('speedmaster_buffer', 'speedmaster_minify_html');
<?php
use MatthiasMullie\Minify;

// Check Speedmaster configuration
if ($smconfig->get('optimizer', 'minify_css')) {
  add_filter('speedmaster_css', 'speedmaster_minify_css');
}

/*
 * Minify CSS
 * Speedmaster Optimizer
 * 
 * This function will minify all outputed CSS.
*/
function speedmaster_minify_css($css) {
  $minifier = new Minify\CSS($css);
  return $minifier->minify();
}
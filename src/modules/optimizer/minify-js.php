<?php
use MatthiasMullie\Minify;

// Check Speedmaster configuration
if ($smconfig->get('optimizer', 'minify_js')) {
  add_filter('speedmaster_js', 'speedmaster_minify_js');
}

/*
 * Minify JS
 * Speedmaster Optimizer
 * 
 * This function will minify all outputed js.
*/
function speedmaster_minify_js($js) {
  $minifier = new Minify\JS($js);
  return $minifier->minify();
}
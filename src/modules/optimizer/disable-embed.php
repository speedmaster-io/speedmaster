<?php

// Check Speedmaster configuration
if ($smconfig->get('optimizer', 'disable_embed')) {
  add_action('wp_footer', 'speedmaster_disable_embed');
}

/**
 * Disable the wp-embed.min.js file
 */
function speedmaster_disable_embed() {
  wp_dequeue_script( 'wp-embed' );
}
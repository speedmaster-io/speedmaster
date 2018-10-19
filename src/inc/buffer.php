<?php
/**
 * Output Buffering
 *
 * Buffers the entire WP process, capturing the final output for manipulation.
 */
ob_start();

define( 'SPEEDMASTER_BUFFER_TIMESTAMP_START', microtime(true)); 

function speedmaster_end_buffer() {
  global $wp_query;
  global $smconfig;

  $buffer = '';

  // Get all output buffer and store it in a variable.
  $buffer = ob_get_clean();

  // Calculate how long time it takes to generate a page.
  $time_before = microtime(true);

  // Apply any filters to the final output
  $filtered_buffer = apply_filters('speedmaster_buffer', $buffer);

  // Calculate how long time it to to optimize page.
  $time_after = microtime(true);

  if ( 
    $smconfig->get('cache', 'enabled') &&
    isset( $wp_query ) && 
    !is_user_logged_in() && 
    !empty($filtered_buffer) && 
    (is_page() || is_front_page() || is_single() || is_archive())
  ) {
    // Save buffer to file if cache is enabled.
    $saved_time = round($time_after - SPEEDMASTER_BUFFER_TIMESTAMP_START,3);
    $identifier = speedmaster_generate_identifier();
    
    speedmaster_save_buffer($identifier, $filtered_buffer . "\n" . '<!-- Speedmaster just saved you '.$saved_time.' second(s). -->');
  }

  echo $filtered_buffer;
}

add_action('shutdown', 'speedmaster_end_buffer', 0);
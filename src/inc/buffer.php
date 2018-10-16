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

  $buffer = '';

  // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
  // that buffer's output into the final output.
  $buffer = ob_get_clean();

  // for ($i = 0; $i < $levels; $i++) {
  //   $buffer .= ob_get_clean();
  // }

  // Apply any filters to the final output
  $time_before = microtime(true);
  $filtered_buffer = apply_filters('speedmaster_buffer', $buffer);
  $time_after = microtime(true);

  $saved_time = round($time_after - SPEEDMASTER_BUFFER_TIMESTAMP_START,3);
  $identifier = speedmaster_generate_identifier();

  if ( isset( $wp_query ) && !is_user_logged_in() && !empty($filtered_buffer) && (is_page() || is_front_page() || is_single() || is_archive()) && defined('SPEEDMASTER_CACHE') && SPEEDMASTER_CACHE == true ) {
    speedmaster_save_buffer($identifier, $filtered_buffer . "\n" . '<!-- Speedmaster just saved you '.$saved_time.' second(s). -->');
  }

  echo $filtered_buffer;
}

add_action('shutdown', 'speedmaster_end_buffer', 0);
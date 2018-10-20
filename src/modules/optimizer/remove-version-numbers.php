<?php
// Check Speedmaster configuration
if ($smconfig->get('optimizer', 'remove_ver')) {
  add_filter( 'style_loader_src',  'speedmaster_remove_ver', 9999, 2 );
  add_filter( 'script_loader_src', 'speedmaster_remove_ver', 9999, 2 );
}

/**
 * Remove version numbers from styles and scripts
 */
function speedmaster_remove_ver( $src, $handle ) 
{
  $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

  if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
      $src = remove_query_arg( 'ver', $src );

  return $src;
}
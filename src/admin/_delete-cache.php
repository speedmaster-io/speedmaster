<?php
function speedmaster_delete_cache_ajax() {
  if (speedmaster_purge_buffer() == true) {
    echo "ok";
  } else {
    echo "error";
  }

  wp_die();
}

function speedmaster_delete_cache_action_js() { ?>
  <script type="text/javascript" >
   jQuery("li#wp-admin-bar-speedmaster-delete-cache .ab-item").on( "click", function() {
      console.log('Clicked');
      var data = { 'action': 'speedmaster_delete_cache'};
      jQuery.post(ajaxurl, data, function(response) {
         if (response == "ok") {
          alert('All cache files were deleted!');
         } else {
          alert('Could not erase cache. Unknown error. Please check your web servers error log for clues.');
         }
      });
    });
  </script> <?php
}

add_action('init', function() {
  if (is_admin()) {
    add_action( 'wp_ajax_speedmaster_delete_cache', 'speedmaster_delete_cache_ajax' );
    add_action( 'admin_footer', 'speedmaster_delete_cache_action_js' );
  }
});


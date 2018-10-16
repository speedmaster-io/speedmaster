<?php
function speedmaster_admin_toolbar($admin_bar){
    $admin_bar->add_menu( array(
      'id'    => 'speedmaster',
      'title' => '<span class="ab-icon dashicons dashicons-smiley"></span> Speedmaster',
      'href'  => admin_url('admin.php?page=speedmaster-dashboard.php')
    ));

    $admin_bar->add_menu( array(
      'id'    => 'speedmaster-delete-cache',
      'parent' => 'speedmaster',
      'title' => 'Purge & Reset Cache',
      'href'  => '#'
    ));
}

add_action('admin_bar_menu', 'speedmaster_admin_toolbar', 90);
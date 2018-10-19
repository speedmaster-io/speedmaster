<?php
// Correctly added scripts and stylesheets
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function enqueue_bootstrap() {
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.css');
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.js', array('jquery'));
}
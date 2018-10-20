<?php
// Correctly added scripts and stylesheets
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function enqueue_bootstrap() {
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.css');
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.js', array('jquery'));
  wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false );


  wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'body-padding', '/wp-content/themes/speedmaster-test/assets/body-padding.css' );
}
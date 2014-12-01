<?php


include_once( __DIR__ . '/includes/plugin-headlines.php' );

add_action( 'wp_enqueue_scripts', 'swwrc_child_enqueue_scripts', 11 );
/**
 * Enqueue custom scripting in child theme.
 */
function swwrc_child_enqueue_scripts() {
	wp_enqueue_script( 'swwrc-setup-nav', get_stylesheet_directory_uri() . '/swwrc-setup-nav.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/custom.js', array( 'swwrc-setup-nav' ), spine_get_script_version(), true );
}
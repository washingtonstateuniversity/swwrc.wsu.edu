<?php

/**
 * Include the functionality used to load the home page's headline
 * and video background features.
 */
include_once( __DIR__ . '/includes/plugin-swwrc-video.php' );

add_action( 'wp_enqueue_scripts', 'swwrc_child_enqueue_scripts', 11 );
/**
 * Enqueue custom scripting in child theme.
 */
function swwrc_child_enqueue_scripts() {
	wp_enqueue_style( 'ascent-style', get_stylesheet_directory_uri() . '/scss/swwrc.css' );
	wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), spine_get_script_version(), true );
}

add_filter( 'pre_get_posts', 'projects_104b' );
/**
 * Query the `wsuwp_uc_project` post type for the 104b category archive.
 */
function projects_104b( $query ) {
  if ( is_category( '104b' ) ) {
    $query->set( 'post_type', array(
     'wsuwp_uc_project'
		) );
	  return $query;
	}
}

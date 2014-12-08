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
	wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), spine_get_script_version(), true );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), spine_get_script_version(), true );
}
add_filter( 'wp_trim_excerpt', 'swwrc_trim_excerpt', 6 );
/**
 * Provide a custom trimmed excerpt forced for SWWRC.
 * Custom excerpt to reject custom DOM while Spine Parent theme is addressed
 *
 * @param string $text The raw excerpt.
 *
 * @return string The modified excerpt.
 */
function swwrc_trim_excerpt( $text ) {
	$raw_excerpt = $text;
	if ( '' !== $text && strpos($text, "<p>") !== false) {
		$text = "<p>".$text."</p>";
	}
	return $text;
}
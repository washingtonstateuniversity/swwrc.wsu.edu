<?php

/**
 * Include the functionality used to load the home page's headline
 * and video background features.
 */
include_once( __DIR__ . '/includes/plugin-swwrc-video.php' );

/**
 * Include custom search functionality.
 */
include_once( __DIR__ . '/includes/custom-search.php' );

/**
 * Include University Center Objects customizations.
 */
include_once( __DIR__ . '/includes/university-center-objects.php' );

add_filter( 'spine_child_theme_version', 'wrc_theme_version' );
/**
 * Provide a theme version for use in cache busting.
 *
 * @since 0.4.15
 *
 * @return string
 */
function wrc_theme_version() {
	return '0.4.15';
}

add_action( 'wp_enqueue_scripts', 'swwrc_child_enqueue_scripts', 11 );
/**
 * Enqueue custom scripting in child theme.
 */
function swwrc_child_enqueue_scripts() {
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), wrc_theme_version(), true );

	if ( is_front_page() ) {
		wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), wrc_theme_version(), true );
		wp_enqueue_script( 'swwrc-home', get_stylesheet_directory_uri() . '/js/home.js', array( 'jquery' ), wrc_theme_version(), true );
	}
}

add_action( 'pre_get_posts', 'projects_104b' );
/**
 * Query the `wsuwp_uc_project` post type for the 104b category archive.
 */
function projects_104b( $query ) {
	if ( is_category( '104b' ) && $query->is_main_query() ) {
		$query->set( 'post_type', array(
			'wsuwp_uc_project',
		) );
	}
}

add_filter( 'wsu_content_syndicate_host_data', 'swwrc_filter_syndicate_host_data', 10, 2 );
/**
 * Filter the thumbnail used from a remote host with WSU Content Syndicate.
 *
 * @param object $subset Data associated with a single remote item.
 * @param object $post   Original data used to build the subset.
 *
 * @return object Modified data.
 */
function swwrc_filter_syndicate_host_data( $subset, $post ) {
	if ( isset( $post->featured_media ) && isset( $subset->featured_media ) ) {
		if ( isset( $subset->featured_media->media_details->sizes->{'spine-medium_size'} ) ) {
			$subset->thumbnail = $subset->featured_media->media_details->sizes->{'spine-medium_size'}->source_url;
		} else {
			$subset->thumbnail = $subset->featured_media->source_url;
		}
	} else {
		$subset->thumbnail = false;
	}

	return $subset;
}

<?php

require_once __DIR__ . '/includes/plugin-swwrc-video.php';
require_once __DIR__ . '/includes/custom-search.php';
require_once __DIR__ . '/includes/university-center-objects.php';
require_once __DIR__ . '/includes/content-syndicate.php';
require_once __DIR__ . '/includes/class-swwrc-uc-taxonomy-terms-widget.php';
require_once __DIR__ . '/includes/class-swwrc-project-category-year-widget.php';

add_filter( 'spine_child_theme_version', 'wrc_theme_version' );
/**
 * Provide a theme version for use in cache busting.
 *
 * @since 0.5.0
 *
 * @return string
 */
function wrc_theme_version() {
	return '0.5.7';
}

add_action( 'wp_enqueue_scripts', 'swwrc_child_enqueue_scripts', 21 );
/**
 * Enqueue custom scripting in child theme.
 */
function swwrc_child_enqueue_scripts() {
	wp_dequeue_script( 'wsu-spine' );
	wp_enqueue_script( 'swwrc-custom', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), wrc_theme_version(), true );
	wp_enqueue_script( 'html5shiv', '//html5shiv.googlecode.com/svn/trunk/html5.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	if ( is_front_page() ) {
		wp_enqueue_script( 'swwrc-videobg', get_stylesheet_directory_uri() . '/js/jQuery.videobg.js', array( 'jquery' ), wrc_theme_version(), true );
		wp_enqueue_script( 'swwrc-home', get_stylesheet_directory_uri() . '/js/home.js', array( 'jquery' ), wrc_theme_version(), true );
	}
}

add_filter( 'terms_clauses', 'swwrc_post_type_terms_clauses', 10, 3 );
/**
 * Extend `get_terms` with a `post_type` parameter.
 *
 * @since 0.5.0
 *
 * @param string $clauses
 * @param string $taxonomy
 * @param array  $args
 *
 * @return string
 */
function swwrc_post_type_terms_clauses( $clauses, $taxonomy, $args ) {
	if ( isset( $args['post_type'] ) && ! empty( $args['post_type'] ) ) {
		global $wpdb;
		$post_types = array();

		if ( is_array( $args['post_type'] ) ) {
			foreach ( $args['post_type'] as $post_type ) {
				$post_types[] = $post_type;
			}
		} else {
			$post_types[] = $args['post_type'];
		}

		if ( ! empty( $post_types ) ) {
			$clauses['join'] .= " INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id";
			$clauses['where'] .= $wpdb->prepare( ' AND p.post_type IN (%s) GROUP BY t.term_id', implode( ',', $post_types ) );
		}
	}

	return $clauses;
}

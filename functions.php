<?php

include_once( __DIR__ . '/includes/plugin-swwrc-video.php' );
include_once( __DIR__ . '/includes/custom-search.php' );
include_once( __DIR__ . '/includes/university-center-objects.php' );
include_once( __DIR__ . '/includes/content-syndicate.php' );

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

/**
 * Returns markup for filtering a list of posts by tag.
 *
 * @since 0.5.0
 *
 * @param string|array $post_type The post type(s) to retrieve associated tags for.
 *
 * @return string
 */
function swwrc_display_uco_tag_filters( $post_type ) {
	if ( in_array( $post_type, wsuwp_uc_get_object_type_slugs(), true ) ) {
		$tags = get_terms( 'post_tag', array(
			'post_type' => $post_type,
		) );

		if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
			?>
			<ul class="swwrc-tag-filters">
				<?php foreach ( $tags as $tag ) { ?>
				<li>
					<label>
						<input type="checkbox"
							   value="tag-<?php echo esc_attr( $tag->slug ); ?>"
							   checked> <?php echo esc_html( $tag->name ); ?>
					</label>
				</li>
				<?php } ?>
			</ul>
			<?php
		}
	}
}
